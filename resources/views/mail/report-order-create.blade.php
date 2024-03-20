<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
</head>
<style>
    .col-md-12 {
        width: 100%
    }

    .container {
        width: 1200px
    }
</style>

<body>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <strong>

                    Subject: DATABASE REPORT NEW ORDER
                </strong>
            </div>
            <br />
            <div class="col-md-12">
                <strong>

                    Dear Sir/ Madam:
                </strong>
            </div>
            <br />
            <div class="col-md-12">
                <strong style="font-size : 12px;">
                     order price:$100
                </strong>

            </div>
            {{-- <div class="col-md-12">
                <p style="color: #2569C3">TAT: ------------- (or as agreed)</p>
            </div> --}}
            <div class="col-md-12">
                <p style="width: 50%">Country : {{$contact_info['country']}} </p>  <p style="width: 50%">Financial : {{$contact_info['financial']}} </p>
                <p style="width: 50%">Company/ Business Name: {{$contact_info['company_name']}}</p>  <p style="width: 50%">investigation Date : {{$contact_info['investigation_date']}} </p>
                <p style="width: 50%">Supplier Code: {{$contact_info['supplier_code']}} 
                <p style="width: 100%">Address : {{$contact_info['address']}}  </p>
            </div>
            <div class="col-md-12">
                <strong>Personal Detail:</strong><br />
                <p style="width: 100%">Name : {{$user['company_name']}}  </p>
                <p style="width: 100%">Email : {{$user['email']}}  </p>
            </div>
            {{-- <br /> --}}
            {{-- <div class="col-md-12">
                <strong style="text-decoration: underline;">Kindly Note:</strong><br />
            </div> --}}
            {{-- <br /> --}}
            {{-- <div class="col-md-12" style="font-size: 13px">
                1. Pl avoid duplication of reports (if already ordered within last 3 months). <br />
                <br />
                2. If the business under investigation is not located or traced, kindly provide NO TRACE/ NOT LOCATED
                information or report mentioning results of investigation without any cost on our account. <br />
                <br />
                3. Pl note to provide finacial details, registry information, directors, shareholders and their
                shareholding., Trade References etc <br />
                <br />
                4. Pl also provide Interview results, person interviewed  and designation, financials / remarks about
                availability of financials and remarks about trade references. <br />
            </div> --}}
            <br />
            <br />
            <div class="col-md-12">
                <div class="col-md-12">
                    <a class="ml-2 me-auto" href="https://creditreport.developer-hi.xyz/">
                        <img style="width: 150px" src="{{ asset('./assets/img/assessbr.png') }}"  alt="access br"/>
                    </a>
                </div>

            </div>
            <div class="col-md-12">
                <p>Address : </p>
            </div>
            <div class="col-md-12">
                <p>website : <a href="https://creditreport.developer-hi.xyz/">Credit Report</p>
            </div>
        </div>
    </div>
</body>
</html>
