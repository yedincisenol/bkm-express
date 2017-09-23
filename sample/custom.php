<?php


?>
<!DOCTYPE HTML>
<html lang="tr"
      xmlns="http://www.w3.org/1999/html">

<head>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.0/jquery.min.js">
    </script>
    <title>Custom Merchant</title>

    <style>
        .btn {
            margin: 0 auto;
            background: #3498db;
            background-image: -webkit-linear-gradient(top, #3498db, #2980b9);
            background-image: -moz-linear-gradient(top, #3498db, #2980b9);
            background-image: -ms-linear-gradient(top, #3498db, #2980b9);
            background-image: -o-linear-gradient(top, #3498db, #2980b9);
            background-image: linear-gradient(to bottom, #3498db, #2980b9);
            -webkit-border-radius: 28;
            -moz-border-radius: 28;
            border-radius: 28px;
            font-family: Arial,serif;
            color: #ffffff;
            font-size: 20px;
            padding: 10px 20px 10px 20px;
            text-decoration: none;
        }

        .btn:hover {
            background: #3cb0fd;
            background-image: -webkit-linear-gradient(top, #3cb0fd, #3498db);
            background-image: -moz-linear-gradient(top, #3cb0fd, #3498db);
            background-image: -ms-linear-gradient(top, #3cb0fd, #3498db);
            background-image: -o-linear-gradient(top, #3cb0fd, #3498db);
            background-image: linear-gradient(to bottom, #3cb0fd, #3498db);
            text-decoration: none;
        }

    </style>

</head>
<body>

<div>
    <table>
        <tr>
            <td>
                    <textarea rows="30" cols="100" id="paymentJson">
                        {
                            "merchantId" : "219be6b7-b3ca-4bd1-9886-a16d40b0bfe2",
                            "merchantPrivateKey" : "MIICdgIBADANBgkqhkiG9w0BAQEFAASCAmAwggJcAgEAAoGBAOLA7InQdCbT8n5Rx8zk8uSCFQ5q4Tyxl0Kr02DoykWxLMBUl1p0YU9hoiocv6Hako5rZssHG0Eb4prh2nmZNpyfhOoOw48Pzg3eB7hKjpXLEPKdK8oemonBcvJ+E9/at4KLg4epyGum1cGdiaYkVF8frG+z53b0ngEq7/CzU8htAgMBAAECgYBNn6OZzf1lKVsy+QX/00R/CzTwGZB/eYABd9bFrwtHbk6WjJ6/fWWuigq8hdjoLG3NSWEIEae30zbwtG5ZACUcNa00Ar9mjsQncZXvLXp9hNb6/TR/mKQvZTjXgoRgn/ltS48GSpqWKbmKVl5JQWgNTb1zHGs2igBb161/ag16tQJBAPzVo2YAVcqXCvuNEWhkqsW1+74GSCrX5QcQwv8qwpt7raumojoFCdeW+xt1Je/bsw01pywkvI3cIO0pdHKwDDcCQQDll7GOPUT/q3Gvmw+kCTnvEH/yYSR2XsPLfEvewxp7SbFI1orLO61A+r5uLDGcfPoxQ7AORzf/OpSfNTD7IGZ7AkAUs5Fbaq+blN5rVlOUjpmE8q+YEX+bMm4oM/EjX2brwCaqJUynH358znnk96SRjRWOAVScwq1FmD6B7KECOvPlAkEA4GaWlXbPFLFGKaP98o9N/5p547YMxGE1L5LqOO0q2euaCp4fBCrs2MD7FYW+a7w/cZ0924bCdYSVNNLxb9IoNwJAJ6PVEsZWT5uGTxqlbTBDFSjHF79OLFWllHsa+2uwf/f6OwNAAMagVbWSdAIlZtaiifDhhXkC4h3ozI1f3xolJg==",
                            "amount" : "1000,52",
                            "useNonce": false,
                            "shouldFail": false,
                            "sendInstallmentUrl": true,
                            "operationTime": 1000,
                            "noResponse": false,
                            "defaultInstallments" : [
                                {
                                    "installmentCount" : 1,
                                    "label" : "Taksit 1",
                                    "interestRate" : 0,
                                    "vposConfig" : {
                                        "vposUserId" : "7000679",
                                        "vposPassword" : "123qweASD",
                                        "extra" : {"terminalprovuserid":"PROVAUT", "terminalmerchantid":"7000679", "storekey":"12345678", "terminalid":"30691297"},
                                        "bankIndicator" : "0062",
                                        "serviceUrl" : "http://srvirt01:7200/VPServlet"
                                    }
                                },
                                {
                                    "installmentCount" : 2,
                                    "label" : "Taksit 2",
                                    "interestRate" : 0.03,
                                    "vposConfig" : {
                                        "vposUserId" : "7000679",
                                        "vposPassword" : "123qweASD",
                                        "extra" : {"terminalprovuserid":"PROVAUT", "terminalmerchantid":"7000679", "storekey":"12345678", "terminalid":"30691297"},
                                        "bankIndicator" : "0062",
                                        "serviceUrl" : "http://srvirt01:7200/VPServlet"
                                    }
                                },
                                {
                                    "installmentCount" : 3,
                                    "label" : "Taksit 3",
                                    "interestRate" : 0.05,
                                    "vposConfig" : {
                                        "vposUserId" : "7000679",
                                        "vposPassword" : "123qweASD",
                                        "extra" : {"terminalprovuserid":"PROVAUT", "terminalmerchantid":"7000679", "storekey":"12345678", "terminalid":"30691297"},
                                        "bankIndicator" : "0062",
                                        "serviceUrl" : "http://srvirt01:7200/VPServlet"
                                    }
                                }
                            ],
                            "banks" : [
                                {
                                    "bankCode" : "0010",
                                    "installments" : [
                                        {
                                            "installmentCount" : 1,
                                            "label" : "Taksit 1",
                                            "interestRate" : 0,
                                            "vposConfig" : {
                                                "vposUserId" : "bkmtest",
                                                "vposPassword" : "TEST1691",
                                                "extra" : {"ClientId":"190001691", "storekey":"TRPS1691", "orderId":"9073194"},
                                                "bankIndicator" : "0010",
                                                "serviceUrl" : "http://srvirt01:7200/ziraat"
                                            }
                                        },
                                        {
                                            "installmentCount" : 3,
                                            "label" : "Taksit 3",
                                            "interestRate" : 0.01,
                                            "vposConfig" : {
                                                "vposUserId" : "bkmtest",
                                                "vposPassword" : "TEST1691",
                                                "extra" : {"ClientId":"190001691", "storekey":"TRPS1691", "orderId":"9073194"},
                                                "bankIndicator" : "0010",
                                                "serviceUrl" : "http://srvirt01:7200/ziraat"
                                            }
                                        }
                                    ]
                                },
                                {
                                    "bankCode" : "0012",
                                    "installments" : [
                                        {
                                            "installmentCount" : 1,
                                            "label" : "Taksit 1",
                                            "interestRate" : 0,
                                            "vposConfig" : {
                                                "vposUserId" : "testapi",
                                                "vposPassword" : "TEST1234",
                                                "extra" : {"ClientId":"500020009", "storekey":"Ab123456","subMerchantName" : "MERCHANT-1-AK"},
                                                "bankIndicator" : "0012",
                                                "serviceUrl" : "http://srvirt01:7200/halkbank"
                                            }
                                        },
                                        {
                                            "installmentCount" : 3,
                                            "label" : "Taksit 3",
                                            "interestRate" : 0.01,
                                            "vposConfig" : {
                                                "vposUserId" : "testapi",
                                                "vposPassword" : "TEST1234",
                                                "extra" : {"ClientId":"500020009", "storekey":"Ab123456"},
                                                "bankIndicator" : "0012",
                                                "serviceUrl" : "http://srvirt01:7200/halkbank"
                                            }
                                        }
                                    ]
                                },
                                {
                                    "bankCode" : "0015",
                                    "installments" : [
                                        {
                                            "installmentCount" : 1,
                                            "label" : "Taksit 1",
                                            "interestRate" : 0,
                                            "vposConfig" : {
                                                "vposUserId" : "000000000011429",
                                                "vposPassword" : "BKMexpress",
                                                "extra" : {"posno":"vp000263","uyeno":"000000000011429","islemyeri":"I","uyeref":"917250515"},
                                                "bankIndicator" : "0015",
                                                "serviceUrl" : "http://srvirt01:7200/vpos724v3/"
                                            }
                                        },
                                        {
                                            "installmentCount" : 3,
                                            "label" : "Taksit 3",
                                            "interestRate" : 0.01,
                                            "vposConfig" : {
                                                "vposUserId" : "000000000011429",
                                                "vposPassword" : "BKMexpress",
                                                "extra" : {"posno":"vp000263","uyeno":"000000000011429","islemyeri":"I","uyeref":"917250515"},
                                                "bankIndicator" : "0015",
                                                "serviceUrl" : "http://srvirt01:7200/vpos724v3/"
                                            }
                                        },
                                        {
                                            "installmentCount" : 6,
                                            "label":"Taksit 5+1",
                                            "interestRate" : 0.08,
                                            "vposConfig" : {
                                                "vposUserId" : "000000000011429",
                                                "vposPassword" : "BKMexpress",
                                                "extra" : {"posno":"vp000263","uyeno":"000000000011429","islemyeri":"I","uyeref":"917250515"},
                                                "bankIndicator" : "0015",
                                                "serviceUrl" : "http://srvirt01:7200/vpos724v3/"
                                            }
                                        }
                                    ]
                                },
                                {
                                    "bankCode" : "0032",
                                    "installments" : [
                                        {
                                            "installmentCount" : 1,
                                            "label" : "Taksit 1",
                                            "interestRate" : 0,
                                            "vposConfig" : {
                                                "vposUserId" : "bkmapi",
                                                "vposPassword" : "KUTU8520",
                                                "extra" : {"ClientId":"401562930", "storekey":"KUTU8520","subMerchantName" : "MERCHANT-1-AK"},
                                                "bankIndicator" : "0032",
                                                "serviceUrl" : "http://srvirt01:7200/teb"
                                            }
                                        },
                                        {
                                            "installmentCount" : 2,
                                            "label":"Taksit 2",
                                            "interestRate" : 0.01,
                                            "vposConfig" : {
                                                "vposUserId" : "bkmapi",
                                                "vposPassword" : "KUTU8520",
                                                "extra" : {"ClientId":"401562930", "storekey":"KUTU8520"},
                                                "bankIndicator" : "0032",
                                                "serviceUrl" : "http://srvirt01:7200/teb"
                                            }
                                        },
                                        {
                                            "installmentCount" : 5,
                                            "label" : "Taksit 3+2",
                                            "interestRate" : 0.05,
                                            "vposConfig" : {
                                                "vposUserId" : "bkmapi",
                                                "vposPassword" : "KUTU8520",
                                                "extra" : {"ClientId":"401562930", "storekey":"KUTU8520"},
                                                "bankIndicator" : "0032",
                                                "serviceUrl" : "http://srvirt01:7200/teb"
                                            }
                                        }
                                    ]
                                },
                                {
                                    "bankCode" : "0046",
                                    "installments" : [
                                        {
                                            "installmentCount" : 1,
                                            "interestRate" : 0,
                                            "vposConfig" : {
                                                "vposUserId" : "akapi",
                                                "vposPassword" : "TEST1234",
                                                "extra" : {"ClientId":"100111222", "storekey":"TEST1234","subMerchantName" : "MERCHANT-1-AK"},
                                                "bankIndicator" : "0046",
                                                "serviceUrl" : "http://srvirt01:7200/akbank"

                                            }


                                        },
                                        {
                                            "installmentCount" : 3,
                                            "interestRate" : 0.01,
                                            "vposConfig" : {
                                                "vposUserId" : "akapi",
                                                "vposPassword" : "TEST1234",
                                                "extra" : {"ClientId":"100111222", "storekey":"TEST1234"},
                                                "bankIndicator" : "0046",
                                                "serviceUrl" : "http://srvirt01:7200/akbank"
                                            }
                                        },
                                        {
                                            "installmentCount" : 5,
                                            "interestRate" : 0.1,
                                            "vposConfig" : {
                                                "vposUserId" : "akapi",
                                                "vposPassword" : "TEST1234",
                                                "extra" : {"ClientId":"100111222", "storekey":"TEST1234"},
                                                "bankIndicator" : "0046",
                                                "serviceUrl" : "http://srvirt01:7200/akbank"
                                            }
                                        }
                                    ]
                                },
                                {
                                    "bankCode" : "0059",
                                    "installments" : [
                                        {
                                            "installmentCount" : 1,
                                            "interestRate" : 0,
                                            "vposConfig" : {
                                                "vposUserId" : "7000679",
                                                "vposPassword" : "123qweASD",
                                                "extra" : {"terminalprovuserid":"PROVAUT", "terminalmerchantid":"7000679", "storekey":"12345678", "terminalid":"30691297"},
                                                "bankIndicator" : "0059",
                                                "serviceUrl" : "http://srvirt01:7200/VPServlet"
                                            }
                                        },
                                        {
                                            "installmentCount" : 2,
                                            "interestRate" : 0.01,
                                            "vposConfig" : {
                                                "vposUserId" : "7000679",
                                                "vposPassword" : "123qweASD",
                                                "extra" : {"terminalprovuserid":"PROVAUT", "terminalmerchantid":"7000679", "storekey":"12345678", "terminalid":"30691297"},
                                                "bankIndicator" : "0059",
                                                "serviceUrl" : "http://srvirt01:7200/VPServlet"
                                            }
                                        },
                                        {
                                            "installmentCount" : 5,
                                            "interestRate" : 0.05,
                                            "vposConfig" : {
                                                "vposUserId" : "7000679",
                                                "vposPassword" : "123qweASD",
                                                "extra" : {"terminalprovuserid":"PROVAUT", "terminalmerchantid":"7000679", "storekey":"12345678", "terminalid":"30691297"},
                                                "bankIndicator" : "0059",
                                                "serviceUrl" : "http://srvirt01:7200/VPServlet"
                                            }
                                        }
                                    ]
                                },
                                {
                                    "bankCode" : "0062",
                                    "installments" : [
                                        {
                                            "installmentCount" : 1,
                                            "label" : "Taksit 1",
                                            "interestRate" : 0,
                                            "vposConfig" : {
                                                "vposUserId" : "7000679",
                                                "vposPassword" : "123qweASD",
                                                "extra" : {"terminalprovuserid":"PROVAUT", "terminalmerchantid":"7000679", "storekey":"12345678", "terminalid":"30691297"},
                                                "bankIndicator" : "0062",
                                                "serviceUrl" : "http://srvirt01:7200/VPServlet"
                                            }
                                        },
                                        {
                                            "installmentCount" : 3,
                                            "label" : "Taksit 2+1",
                                            "interestRate" : 0.01,
                                            "vposConfig" : {
                                                "vposUserId" : "7000679",
                                                "vposPassword" : "123qweASD",
                                                "extra" : {"terminalprovuserid":"PROVAUT", "terminalmerchantid":"7000679", "storekey":"12345678", "terminalid":"30691297"},
                                                "bankIndicator" : "0062",
                                                "serviceUrl" : "http://srvirt01:7200/VPServlet"
                                            }
                                        },
                                        {
                                            "installmentCount" : 4,
                                            "interestRate" : 0.05,
                                            "vposConfig" : {
                                                "vposUserId" : "7000679",
                                                "vposPassword" : "123qweASD",
                                                "extra" : {"terminalprovuserid":"PROVAUT", "terminalmerchantid":"7000679", "storekey":"12345678", "terminalid":"30691297"},
                                                "bankIndicator" : "0062",
                                                "serviceUrl" : "http://srvirt01:7200/VPServlet"
                                            }
                                        },
                                        {
                                            "installmentCount" : 5,
                                            "interestRate" : 0.05,
                                            "vposConfig" : {
                                                "vposUserId" : "7000679",
                                                "vposPassword" : "123qweASD",
                                                "extra" : {"terminalprovuserid":"PROVAUT", "terminalmerchantid":"7000679", "storekey":"12345678", "terminalid":"30691297"},
                                                "bankIndicator" : "0062",
                                                "serviceUrl" : "http://srvirt01:7200/VPServlet"
                                            }
                                        },
                                        {
                                            "installmentCount" : 6,
                                            "interestRate" : 0.06,
                                            "vposConfig" : {
                                                "vposUserId" : "7000679",
                                                "vposPassword" : "123qweASD",
                                                "extra" : {"terminalprovuserid":"PROVAUT", "terminalmerchantid":"7000679", "storekey":"12345678", "terminalid":"30691297"},
                                                "bankIndicator" : "0062",
                                                "serviceUrl" : "http://srvirt01:7200/VPServlet"
                                            }
                                        }
                                    ]
                                },
                                {
                                    "bankCode" : "0064",
                                    "installments" : [
                                        {
                                            "installmentCount" : 1,
                                            "interestRate" : 0,
                                            "vposConfig" : {
                                                "vposUserId" : "bkmapi",
                                                "vposPassword" : "KUTU8900",
                                                "extra" : {"ClientId":"700655047520", "storekey":"TEST123456","subMerchantName" : "MERCHANT-1-AK"},
                                                "bankIndicator" : "0064",
                                                "serviceUrl" : "http://srvirt01:7200/isbank"
                                            }
                                        },
                                        {
                                            "installmentCount" : 3,
                                            "interestRate" : 0.01,
                                            "vposConfig" : {
                                                "vposUserId" : "bkmapi",
                                                "vposPassword" : "KUTU8900",
                                                "extra" : {"ClientId":"700655047520", "storekey":"TEST123456"},
                                                "bankIndicator" : "0064",
                                                "serviceUrl" : "http://srvirt01:7200/isbank"
                                            }
                                        }
                                    ]
                                },
                                {
                                    "bankCode" : "0067",
                                    "installments" : [
                                        {
                                            "installmentCount" : 1,
                                            "interestRate" : 0,
                                            "vposConfig" : {
                                                "vposUserId" : "bkm3d1",
                                                "vposPassword" : "12345",
                                                "extra" : {"mid":"6706598320", "tid": "67245089", "posnetID": "4280"},
                                                "bankIndicator" : "0067",
                                                "serviceUrl" : "http://srvirt01:7200/PosnetWebService/XML"
                                            }
                                        },
                                        {
                                            "installmentCount" : 3,
                                            "interestRate" : 0.01,
                                            "vposConfig" : {
                                                "vposUserId" : "bkm3d1",
                                                "vposPassword" : "12345",
                                                "extra" : {"mid":"6706598320", "tid": "67245089", "posnetID": "4280"},
                                                "bankIndicator" : "0067",
                                                "serviceUrl" : "http://srvirt01:7200/PosnetWebService/XML"
                                            }
                                        },
                                        {
                                            "installmentCount" : 4,
                                            "interestRate" : 0.08,
                                            "vposConfig" : {
                                                "vposUserId" : "bkm3d1",
                                                "vposPassword" : "12345",
                                                "extra" : {"mid":"6706598320", "tid": "67245089", "posnetID": "4280"},
                                                "bankIndicator" : "0067",
                                                "serviceUrl" : "http://srvirt01:7200/PosnetWebService/XML"
                                            }
                                        },
                                        {
                                            "installmentCount" : 5,
                                            "interestRate" : 0.010,
                                            "vposConfig" : {
                                                "vposUserId" : "bkm3d1",
                                                "vposPassword" : "12345",
                                                "extra" : {"mid":"6706598320", "tid": "67245089", "posnetID": "4280"},
                                                "bankIndicator" : "0067",
                                                "serviceUrl" : "http://srvirt01:7200/PosnetWebService/XML"
                                            }
                                        }
                                    ]
                                },
                                {
                                    "bankCode" : "0099",
                                    "installments" : [
                                        {
                                            "installmentCount" : 1,
                                            "interestRate" : 0,
                                            "vposConfig" : {
                                                "vposUserId" : "7000679",
                                                "vposPassword" : "123qweASD",
                                                "extra" : {"terminalprovuserid":"PROVAUT", "terminalmerchantid":"7000679", "storekey":"12345678", "terminalid":"30691297"},
                                                "bankIndicator" : "0099",
                                                "serviceUrl" : "http://srvirt01:7200/VPServlet"
                                            }
                                        },
                                        {
                                            "installmentCount" : 3,
                                            "interestRate" : 0.01,
                                            "vposConfig" : {
                                                "vposUserId" : "7000679",
                                                "vposPassword" : "123qweASD",
                                                "extra" : {"terminalprovuserid":"PROVAUT", "terminalmerchantid":"7000679", "storekey":"12345678", "terminalid":"30691297"},
                                                "bankIndicator" : "0099",
                                                "serviceUrl" : "http://srvirt01:7200/VPServlet"
                                            }
                                        },
                                        {
                                            "installmentCount" : 4,
                                            "interestRate" : 0.05,
                                            "vposConfig" : {
                                                "vposUserId" : "7000679",
                                                "vposPassword" : "123qweASD",
                                                "extra" : {"terminalprovuserid":"PROVAUT", "terminalmerchantid":"7000679", "storekey":"12345678", "terminalid":"30691297"},
                                                "bankIndicator" : "0099",
                                                "serviceUrl" : "http://srvirt01:7200/VPServlet"
                                            }
                                        },
                                        {
                                            "installmentCount" : 5,
                                            "interestRate" : 0.07,
                                            "vposConfig" : {
                                                "vposUserId" : "7000679",
                                                "vposPassword" : "123qweASD",
                                                "extra" : {"terminalprovuserid":"PROVAUT", "terminalmerchantid":"7000679", "storekey":"12345678", "terminalid":"30691297"},
                                                "bankIndicator" : "0099",
                                                "serviceUrl" : "http://srvirt01:7200/VPServlet"
                                            }
                                        }
                                    ]
                                },
                                {
                                    "bankCode" : "0111",
                                    "installments" : [
                                        {
                                            "installmentCount" : 1,
                                            "interestRate" : 0,
                                            "vposConfig" : {
                                                "vposUserId" : "bkmapi",
                                                "vposPassword" : "TEST1234",
                                                "extra" : {
                                            "ClientId":"600000120",
                                            "storekey":"TEST1234",
                                            "subMerchantName" : "MERCHANT-NAME-FINANS",
                                            "subMerchantId" : "MERCHANT-ID",
                                            "subMerchantPostalCode" : "34000",
                                            "subMerchantCity" : "MERCHANT-CITY",
                                            "subMerchantCountry" : "MERCHANT-COUNTRY"
                                            },
                                                "bankIndicator" : "0111",
                                                "serviceUrl" : "http://srvirt01:7200/finans"
                                            }

                                        },
                                        {
                                            "installmentCount" : 3,
                                            "interestRate" : 0.01,
                                            "vposConfig" : {
                                                "vposUserId" : "bkmapi",
                                                "vposPassword" : "TEST1234",
                                                "extra" : {"ClientId":"600000120", "storekey":"TEST1234"},
                                                "bankIndicator" : "0111",
                                                "serviceUrl" : "http://srvirt01:7200/finans"
                                            }
                                        },
                                        {
                                            "installmentCount" : 5,
                                            "interestRate" : 0.04,
                                            "vposConfig" : {
                                                "vposUserId" : "bkmapi",
                                                "vposPassword" : "TEST1234",
                                                "extra" : {"ClientId":"600000120", "storekey":"TEST1234"},
                                                "bankIndicator" : "0111",
                                                "serviceUrl" : "http://srvirt01:7200/finans"
                                            }
                                        },
                                        {
                                            "installmentCount" : 6,
                                            "interestRate" : 0.05,
                                            "vposConfig" : {
                                                "vposUserId" : "bkmapi",
                                                "vposPassword" : "TEST1234",
                                                "extra" : {"ClientId":"600000120", "storekey":"TEST1234"},
                                                "bankIndicator" : "0111",
                                                "serviceUrl" : "http://srvirt01:7200/finans"
                                            }
                                        }
                                    ]
                                },
                                {
                                    "bankCode" : "0123",
                                    "installments" : [
                                        {
                                            "installmentCount" : 1,
                                            "interestRate" : 0,
                                            "vposConfig" : {
                                                "vposUserId" : "a",
                                                "vposPassword" : "TEST1234",
                                                "extra" : {"ClientId":"0004220"},
                                                "bankIndicator" : "0123",
                                                "serviceUrl" : "https://vpostest.advantage.com.tr/servlet/cc5ApiServer"
                                            }
                                        },
                                        {
                                            "installmentCount" : 3,
                                            "interestRate" : 0.01,
                                            "vposConfig" : {
                                                "vposUserId" : "a",
                                                "vposPassword" : "TEST1234",
                                                "extra" : {"ClientId":"0004220"},
                                                "bankIndicator" : "0123",
                                                "serviceUrl" : "https://vpostest.advantage.com.tr/servlet/cc5ApiServer"
                                            }
                                        },
                                        {
                                            "installmentCount" : 6,
                                            "interestRate" : 0.05,
                                            "vposConfig" : {
                                                "vposUserId" : "a",
                                                "vposPassword" : "TEST1234",
                                                "extra" : {"ClientId":"0004220"},
                                                "bankIndicator" : "0123",
                                                "serviceUrl" : "https://vpostest.advantage.com.tr/servlet/cc5ApiServer"
                                            }
                                        }
                                    ]
                                },
                                {
                                    "bankCode" : "0134",
                                    "installments" : [
                                        {
                                            "installmentCount" : 1,
                                            "interestRate" : 0,
                                            "vposConfig" : {
                                                "vposUserId" : "1",
                                                "vposPassword" : "12345",
                                                "extra" : {"ShopCode":"3123", "UserCode":"InterTestApi", "UserPass":"3","storeKey":"gDg1N"},
                                                "bankIndicator" : "0134",
                                                "serviceUrl" : "http://srvirt01:7200/mpi/Default.aspx"
                                            }
                                        },
                                        {
                                            "installmentCount" : 3,
                                            "interestRate" : 0.01,
                                            "vposConfig" : {
                                                "vposUserId" : "1",
                                                "vposPassword" : "12345",
                                                "extra" : {"ShopCode":"3123", "UserCode":"InterTestApi", "UserPass":"3","storeKey":"gDg1N"},
                                                "bankIndicator" : "0134",
                                                "serviceUrl" : "http://srvirt01:7200/mpi/Default.aspx"
                                            }
                                        },
                                        {
                                            "installmentCount" : 4,
                                            "interestRate" : 0.01,
                                            "vposConfig" : {
                                                "vposUserId" : "1",
                                                "vposPassword" : "12345",
                                                "extra" : {"ShopCode":"3123", "UserCode":"InterTestApi", "UserPass":"3","storeKey":"gDg1N"},
                                                "bankIndicator" : "0134",
                                                "serviceUrl" : "http://srvirt01:7200/mpi/Default.aspx"
                                            }
                                        }
                                    ]
                                },
                                {
                                    "bankCode" : "0146",
                                    "installments" : [
                                        {
                                            "installmentCount" : 1,
                                            "interestRate" : 0,
                                            "vposConfig" : {
                                                "vposUserId" : "7000679",
                                                "vposPassword" : "123qweASD",
                                                "extra" : {"terminalprovuserid":"PROVAUT", "terminalmerchantid":"7000679", "storekey":"12345678", "terminalid":"30691297"},
                                                "bankIndicator" : "0146",
                                                "serviceUrl" : "http://srvirt01:7200/VPServlet"
                                            }
                                        },
                                        {
                                            "installmentCount" : 2,
                                            "interestRate" : 0.01,
                                            "vposConfig" : {
                                                "vposUserId" : "7000679",
                                                "vposPassword" : "123qweASD",
                                                "extra" : {"terminalprovuserid":"PROVAUT", "terminalmerchantid":"7000679", "storekey":"12345678", "terminalid":"30691297"},
                                                "bankIndicator" : "0146",
                                                "serviceUrl" : "http://srvirt01:7200/VPServlet"
                                            }
                                        },
                                        {
                                            "installmentCount" : 4,
                                            "interestRate" : 0.02,
                                            "vposConfig" : {
                                                "vposUserId" : "7000679",
                                                "vposPassword" : "123qweASD",
                                                "extra" : {"terminalprovuserid":"PROVAUT", "terminalmerchantid":"7000679", "storekey":"12345678", "terminalid":"30691297"},
                                                "bankIndicator" : "0146",
                                                "serviceUrl" : "http://srvirt01:7200/VPServlet"
                                            }
                                        }
                                    ]
                                },
                                {
                                    "bankCode" : "0203",
                                    "installments" : [
                                        {
                                            "installmentCount" : 1,
                                            "interestRate" : 0,
                                            "vposConfig" : {
                                                "vposUserId" : "7000679",
                                                "vposPassword" : "123qweASD",
                                                "extra" : {"terminalprovuserid":"PROVAUT", "terminalmerchantid":"7000679", "storekey":"12345678", "terminalid":"30691297"},
                                                "bankIndicator" : "0203",
                                                "serviceUrl" : "http://srvirt01:7200/VPServlet"
                                            }
                                        },
                                        {
                                            "installmentCount" : 3,
                                            "interestRate" : 0.01,
                                            "vposConfig" : {
                                                "vposUserId" : "7000679",
                                                "vposPassword" : "123qweASD",
                                                "extra" : {"terminalprovuserid":"PROVAUT", "terminalmerchantid":"7000679", "storekey":"12345678", "terminalid":"30691297"},
                                                "bankIndicator" : "0203",
                                                "serviceUrl" : "http://srvirt01:7200/VPServlet"
                                            }
                                        },
                                        {
                                            "installmentCount" : 4,
                                            "interestRate" : 0.07,
                                            "vposConfig" : {
                                                "vposUserId" : "7000679",
                                                "vposPassword" : "123qweASD",
                                                "extra" : {"terminalprovuserid":"PROVAUT", "terminalmerchantid":"7000679", "storekey":"12345678", "terminalid":"30691297"},
                                                "bankIndicator" : "0203",
                                                "serviceUrl" : "http://srvirt01:7200/VPServlet"
                                            }
                                        }
                                    ]
                                },
                                {
                                    "bankCode" : "0205",
                                    "installments" : [
                                        {
                                            "installmentCount" : 1,
                                            "interestRate" : 0,
                                            "vposConfig" : {
                                                "vposUserId" : "apiuser",
                                                "vposPassword" : "Api123",
                                                "extra" : {"MerchantId":"2","CustomerId":"8736633","orderId":"852507088"},
                                                "bankIndicator" : "0205",
                                                "serviceUrl" : "https://boatest.kuveytturk.com.tr/boa.virtualpos.services/Home/ThreeDModelGate"
                                            }
                                        },
                                        {
                                            "installmentCount" : 3,
                                            "interestRate" : 0.01,
                                            "vposConfig" : {
                                                "vposUserId" : "apiuser",
                                                "vposPassword" : "Api123",
                                                "extra" : {"MerchantId":"2","CustomerId":"8736633","orderId":"852507088"},
                                                "bankIndicator" : "0205",
                                                "serviceUrl" : "https://boatest.kuveytturk.com.tr/boa.virtualpos.services/Home/ThreeDModelGate"
                                            }
                                        },
                                        {
                                            "installmentCount" : 9,
                                            "interestRate" : 0.05,
                                            "vposConfig" : {
                                                "vposUserId" : "apiuser",
                                                "vposPassword" : "Api123",
                                                "extra" : {"MerchantId":"2","CustomerId":"8736633","orderId":"852507088"},
                                                "bankIndicator" : "0205",
                                                "serviceUrl" : "https://boatest.kuveytturk.com.tr/boa.virtualpos.services/Home/ThreeDModelGate"
                                            }
                                        }
                                    ]
                                },
                                {
                                    "bankCode" : "0206",
                                    "installments" : [
                                        {
                                            "installmentCount" : 1,
                                            "interestRate" : 0,
                                            "vposConfig" : {
                                                "vposUserId" : "",
                                                "vposPassword" : "",
                                                "extra" : {"orgNo":"006", "firmNo":"9470335", "termNo":"955434","merchantKey":"HngvXM22","orderId":"674451441"},
                                                "bankIndicator" : "0206",
                                                "serviceUrl" : "https://testserver1:15443/BKMExpressServices.asmx"
                                            }
                                        },
                                        {
                                            "installmentCount" : 3,
                                            "interestRate" : 0.01,
                                            "vposConfig" : {
                                                "vposUserId" : "",
                                                "vposPassword" : "",
                                                "extra" : {"orgNo":"006", "firmNo":"9470335", "termNo":"955434","merchantKey":"HngvXM22","orderId":"674451441"},
                                                "bankIndicator" : "0206",
                                                "serviceUrl" : "https://testserver1:15443/BKMExpressServices.asmx"
                                            }
                                        },
                                        {
                                            "installmentCount" : 4,
                                            "interestRate" : 0.05,
                                            "vposConfig" : {
                                                "vposUserId" : "",
                                                "vposPassword" : "",
                                                "extra" : {"orgNo":"006", "firmNo":"9470335", "termNo":"955434","merchantKey":"HngvXM22","orderId":"674451441"},
                                                "bankIndicator" : "0206",
                                                "serviceUrl" : "https://testserver1:15443/BKMExpressServices.asmx"
                                            }
                                        }
                                    ]
                                },
                                {
                                    "bankCode" : "0208",
                                    "installments" : [
                                        {
                                            "installmentCount" : 1,
                                            "interestRate" : 0,
                                            "vposConfig" : {
                                                "vposUserId" : "",
                                                "vposPassword" : "",
                                                "extra" : {"MerchantId":"006100200140200", "MerchantPassword":"12345678"},
                                                "bankIndicator" : "208",
                                                "serviceUrl" : "http://srvirt01:7200/iposnet/sposnet.aspx"
                                            }
                                        },
                                        {
                                            "installmentCount" : 3,
                                            "interestRate" : 0.01,
                                            "vposConfig" : {
                                                "vposUserId" : "",
                                                "vposPassword" : "",
                                                "extra" : {"MerchantId":"006100200140200", "MerchantPassword":"12345678"},
                                                "bankIndicator" : "208",
                                                "serviceUrl" : "http://srvirt01:7200/iposnet/sposnet.aspx"
                                            }
                                        },
                                        {
                                            "installmentCount" : 5,
                                            "interestRate" : 0.02,
                                            "vposConfig" : {
                                                "vposUserId" : "",
                                                "vposPassword" : "",
                                                "extra" : {"MerchantId":"006100200140200", "MerchantPassword":"12345678"},
                                                "bankIndicator" : "208",
                                                "serviceUrl" : "http://srvirt01:7200/iposnet/sposnet.aspx"
                                            }
                                        }
                                    ]
                                }

                            ]
                        }
                    </textarea>
            </td>
            <td style="vertical-align:bottom; width: 100%; text-align: center;">
                <a class="btn" id="initializePayment">Start Payment</a>
            </td>
        </tr>
    </table>
</div>

<script type="text/javascript">

        $("#initializePayment").click(function() {
            console.log( "started!" );
            $('#payment-dropin').empty();

            var jsonData = JSON.parse($("#paymentJson").val());
            $.ajax({
                type : "POST",
                url:"customController.php?customStart=init",
                data : JSON.stringify(jsonData),
                contentType: "application/json;",
                dataType: "json",
                timeout : 100000,
                success : function(data) {

                    var ticketShortId = data.ticketShortId;
                    var ticketPath = data.ticketPath;
                    var ticketToken = data.ticketToken;
                   start(ticketShortId,ticketPath,ticketToken)
                }
            });

            console.log( "ended!" );
        });


        /*<![CDATA[*/
        function start(ticketShortId,ticketPath,ticketToken){
            var ticketPathForStart = ticketPath;
            Bex.init({"id":ticketShortId,"path":ticketPath,"token":ticketToken}, "modal", {
                container: "payment-dropin",
                buttonSize: [135, 70],
                onCancel: function(){
                    var jsonData = JSON.parse($("#paymentJson").val());
                    $.ajax({
                        type: "POST",
                        url: "customController.php?custom=reinit",
                        data : JSON.stringify(jsonData),
                        contentType: "application/json;",
                        timeout: 100000,
                        success: function (data) {
                            if(typeof data !='undefined') {
                                var ticketObj = [];
                                ticketObj["id"] = JSON.parse(data).id;
                                ticketObj["path"] = JSON.parse(data).path;
                                ticketObj["token"] = JSON.parse(data).token;
                                Bex.refresh(ticketObj);

                            }
                        }
                    });

                    console.info("User canceled the payment");
                },
                onComplete: function(status){

                    $.ajax({
                        type : 'post',
                        url : "customController.php?customResult="+ticketPathForStart,
                        data : {ticketId: "'"+ticketPathForStart+"'"},
                        contentType: "application/json",
                        success : function(data) {
                            if(typeof data !='undefined') {

                                $('#bkmInstallmentCount').text(JSON.parse(data).installmentCount);
                                $('#bkmTotalAmount').text(JSON.parse(data).totalAmount);
                                $('#bkmCard').text(JSON.parse(data).cardData);
                                $('#bkmTokenId').text(JSON.parse(data).bkmTokenId);
                                $('#posResult').text(JSON.stringify(JSON.parse(data).posResult));
                                $('#paymentSuccess').show();
                                $('#paymentField').hide();
                            }
                        }
                    });

                    console.info("Payment completed with status: " + status);
                }
            });
        }
        /*]]>*/

</script>

<br />

<hr />

<br />

<span id="paymentCanceled" style="color: #7A162E; font-size: 30px;  display: none;">
        Ödemeyi gerçekleştirmediniz....
    </span>

<span id="paymentSuccess" style="color: #54900f; font-size: 30px;  display: none;">
        Ödemeniz başarıyla tamamlandı....

        <br/>Taksit Adedi       : <span id="bkmInstallmentCount"></span>
        <br/>Toplam Tutar       : <span id="bkmTotalAmount"></span>
        <br/>İşlem Yapılan Kart : <span id="bkmCard"></span>
        <br/>BkmTokenId          : <span id="bkmTokenId"></span>
        <br/>PosResult          : <span id="posResult"></span>
    </span>


<div id="paymentField">
    <div id="payment-dropin" style="top: 20px; right: 10px; position: relative; text-align: center;">

    </div>
    <script src = "https://bex-js.finartz.com/v1/javascripts/bex.js" type="text/javascript"></script>

</div>

</body>
</html>
