import sys
import pickle
import json
import pandas as pd
import numpy as np
import os
from sklearn.linear_model import LogisticRegression
from sklearn.linear_model import LinearRegression
from scipy import stats
import base64

def apply_regulation(data, col_name, maxs, mins):
    data.loc[:,col_name] = (data[col_name] - mins) / (maxs - mins)
    return data    

def de_regulation(data, maxs, mins):
    data = data * (maxs - mins) + mins
    return data

def run(model, y, maxs_list, mins_list, mm_dict, inde_list, target_v):
    if model.__class__.__name__ == 'LinearRegression':
        new_list = []
        for column in inde_list:
            if column in one_person:
                new_list.append(float(one_person[column]))
            elif (column.split('_')[0] in one_person) and (column.split('_')[1] == one_person[column.split('_')[0]]):
                new_list.append(1)
            else:
                new_list.append(0)
        new_list = [new_list]
        X_a = pd.DataFrame(new_list, columns = inde_list)
        for item in mm_dict:
            if item in list(X_a.columns):
                X_a = apply_regulation(X_a, item, maxs_list[mm_dict[item]], mins_list[mm_dict[item]])

        result = model.predict(X_a)
        resultp = stats.percentileofscore(y, result)
        result = de_regulation(result, maxs_list[mm_dict[target_v]], mins_list[mm_dict[target_v]])
        result = result[0]
    else:
        new_list = []
        for column in inde_list:
            if column in one_person:
                new_list.append(float(one_person[column]))
            elif (column.split('_')[0] in one_person) and (column.split('_')[1] == one_person[column.split('_')[0]]):
                new_list.append(1)
            else:
                new_list.append(0)
        new_list = [new_list]
        X_a = pd.DataFrame(new_list, columns = inde_list)

        for item in mm_dict:
            if item in list(X_a.columns):
                X_a = apply_regulation(X_a, item, maxs_list[mm_dict[item]], mins_list[mm_dict[item]])

        result = model.predict_proba(X_a)
        result = result[0][1]
        resultp = 0
    return result, resultp

# read inputs

# Load the data that PHP sent us
'''
one_person = {
    'Age' : 44,
    'Agent Has Sales Mgt Responsibilities' : 'NO',
    'Agent Received New-agent Financing During the Year' : 'YES',
    'Company - Code' : 'A01',
    'Compensation - Total Earnings' : 18907,
    'FYCs - Total' : 15537,
    'Gender' : 'Male',
    'LOS (Completed Years)' : 1,
    'License - Series 23 24 26 Securities' : 'No',
    'License - Series 6 Securities' : 'Yes',
    'License - Series 63 65 66 Securities' : 'No',
    'License - Series 7 Securities' : 'No',
    'New Policies - Total' : 24,
    'Premiums - Total' : 32976,
    'Prior Insurance Sales Experience' : 'No Insurance Sales Exp',
    'Record Type' : 'Active Agent',
    'Record Year' : '2010',
    'State Name' : 'Florida'    
}
'''
#print(base64.b64decode(sys.argv[1]))
one_person = json.loads(base64.b64decode(sys.argv[1]).decode("utf-8"))
new = one_person.copy()
for item in new:
    newkey = " ".join(item.split("_"))
    one_person[newkey] = one_person[item]
    del one_person[item]


# craete results saver
results = dict()
results['P1'] = int(one_person["Premiums - Total"])
results['C1'] = int(one_person["Compensation - Total Earnings"])
results['StateName'] = one_person["State Name"]
results['CompanyCode'] = one_person["Company - Code"]
results['radar'] = {}
with open('/var/www/html/project1/stateA.json', 'r') as f:
    results['stateA'] = json.load(f)
with open('/var/www/html/project1/company.json', 'r') as f:
    results['company'] = json.load(f)

# read models
os_dir = '/var/www/html/models/'
for filename in os.listdir(os_dir):
    with open((os_dir+filename), 'rb') as f:
        model, y, maxs_list, mins_list, mm_dict, inde_list, target_v = pickle.load(f)
        try:
            result, resultp = run(model, y, maxs_list, mins_list, mm_dict, inde_list, target_v)
        except Exception as e: print(e)
        keyname = filename.split('_')[1].split('.')[0]
        results[keyname] = result
        results[(keyname + 'P')] = round(resultp)
        if keyname=='P2':
            results['radar']['E'] = resultp // 10 +1
        if keyname=='C2':
            results['radar']['C'] = resultp // 10 +1
        if keyname=='LS':
            results['radar']['L'] = resultp // 10 +1



# outputs
#print(results)


# Send it to stdout (to PHP)
print(json.dumps(results))
