function generatePDF(callCode) {
     alert(callCode);
     const url = `generate_pdf.php?call_code=${callCode}`;
     window.open(url, '_blank', 'width=800,height=600');
}
function show(callCode) {
     var req = new XMLHttpRequest();
     var form = new FormData();
     form.append("callecode", callCode);
     req.onreadystatechange = function () {
          if (req.readyState === 4) {
               if (req.status === 200) {
                    try {
                         var response = JSON.parse(req.responseText);
                         if (response.success) {
                              // alert(response.code);
                              document.querySelector('#callid').value = response.code;
                              document.querySelector('#exampleModalLabel').innerHTML = '<i class="fa-regular fa-phone"></i>&nbsp; Call Details';
                              document.querySelector('#floatingInput').value = response.name;
                              document.querySelector('#floatingInputDate').value = response.date_time;
                              document.querySelector('#floatingInputDistrict').value = response.district;
                              document.querySelector('#floatingInputSystem').value = response.system_type;
                              document.querySelector('#floatingInputDescription').value = response.description;
                              var modal = new bootstrap.Modal(document.getElementById('modal'));
                              modal.show();
                         } else {
                              alert(response.message || 'Something went wrong.');
                         }
                    } catch (e) {
                         console.error('Error parsing JSON response:', e);
                         alert('Failed to load call details.');
                    }
               } else {
                    console.error('An error occurred:', req.statusText);
               }
          }
     };
     req.open("POST", "fetch_call_details.php", true);
     req.send(form);
}

function Update() {

     var callid = document.querySelector('#callid').value;
     var description = document.querySelector('#floatingInputDescription').value;
     var note = document.querySelector('#floatingInputNote').value;

     var req = new XMLHttpRequest();
     form = new FormData();
     form.append("cid", callid);
     form.append("des", description);
     form.append("note", note);
     req.onreadystatechange = function () {
          if (req.readyState === 4) {
               if (req.status === 200) {
                    var x = req.responseText;
                    alert(x);
               }
          }
     }
     req.open("POST", "update_call_details.php", true);
     req.send(form);
}
function whynote(callCode) {
     alert(callCode);
     var req = new XMLHttpRequest();
     var form = new FormData();
     form.append("callecode", callCode);
     req.onreadystatechange = function () {
          if (req.readyState === 4) {
               if (req.status === 200) {
                    var response = JSON.parse(req.responseText);
                    if (response.success) {
                         alert(response.code);
                         document.querySelector('#callid').value = response.code;
                         var modal = new bootstrap.Modal(document.getElementById('modal'));
                         modal.show();
                    }
               }
          }
     }
     req.open("POST", "detail.php", true);
     req.send(form);
}
function missnotesave(){
     var callid = document.querySelector('#callid').value;
     var note = document.getElementById("floatingInputnote").value;
     var req = new XMLHttpRequest();
     form = new FormData();
     form.append("code",callid);
     form.append("snote",note);
     req.onreadystatechange = function () {
          if (req.readyState === 4) {
               if (req.status === 200) {
                    var x = req.responseText;
                    alert(x);
               }
          }
     }
     req.open("POST", "up_miss_details.php", true);
     req.send(form);
}
function AddDeadline(code){
     var Deadline = document.getElementById("Deadline").value;
    var req = new XMLHttpRequest();
    var form = new FormData();
    form.append("Deadline",Deadline);
    form.append("code",code);
    req.onreadystatechange = function () {
     if (req.readyState === 4) {
          if (req.status === 200) {
               var x = req.responseText;
               alert(x);
          }
     }
}
req.open("POST", "ADDDeadline.php", true);
req.send(form);
}
