user: {{$username}};<br>
deal title: {{$deal_title}};<br> <br>
download list as PFD: {{asset('pdf').'/'.md5($owner_email).'.pdf'}}