# NSLV: NtopNG Simple netflowLog Viewer
 
Simple utility, that connect to [ntopng](https://www.ntop.org/) collected flow and gather simple info. Ntopng use mysql  [RDBMS](https://www.ntop.org/guides/ntopng/advanced_features/flows_dump.html#mysql).  

Utility gather ip-addr for L7 protocols: HTTP(code 7) and HTTPS (code 178) and resolve them into DNS names.



### Please, dont forget change your creds!

Simple output:
```
'ec2-34-218-94-234.us-west-2.compute.amazonaws.com'
'ec2-54-70-112-150.us-west-2.compute.amazonaws.com'
'api-maps.yandex.ru'
'ec2-52-33-240-131.us-west-2.compute.amazonaws.com'
'api-maps.yandex.ru'
'ec2-54-70-189-171.us-west-2.compute.amazonaws.com'
'ec2-52-33-240-131.us-west-2.compute.amazonaws.com'
```

License: MIT  

Author: [ep4sh](https://github.com/ep4sh)
