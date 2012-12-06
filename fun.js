function dateFun(){
   var datefield=document.createElement("input")
   datefield.setAttribute("type", "date")
       if(datefield.type!="date"){ //sprawdza czy przegladarka obsluguje input type="date"
               alert("Do przeglądania tej strony polecamy przeglądarkę Google Chrome!");
               document.getElementById('datepicker').style.display='none';
               document.getElementById('dateIE').style.display='block';
               
               document.getElementById('dDate').required=true;
               document.getElementById('mDate').required=true;
               document.getElementById('yDate').required=true;
       }
       else{
               document.getElementById('datepicker').required=true;
       }
}