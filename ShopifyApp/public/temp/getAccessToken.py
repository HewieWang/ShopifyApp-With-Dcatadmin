import requests,sys

url = sys.argv[1]

payload = {}
headers = {}

response = requests.request("POST", url, headers=headers, data=payload,timeout=30)

print(response.json())