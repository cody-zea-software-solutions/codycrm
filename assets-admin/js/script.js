function tProductImage(x) {

    var imageInput = document.getElementById("img_input_" + x);
    imageInput.click();

    imageInput.addEventListener("change", function handleImageChange() {
        var fileCount = imageInput.files.length;

        if (fileCount === 1) {
            var file = imageInput.files[0];

            // Validate file type
            var allowedTypes = ["image/jpg", "image/jpeg", "image/png", "image/webp"];
            if (!allowedTypes.includes(file.type)) {
                alert("Invalid file type. Please select a JPG, JPEG, PNG, or WEBP image.");
                imageInput.value = ""; // Clear the invalid input
                return;
            }

            // Validate file size (e.g., max 5MB)
            var maxSize = 5 * 1024 * 1024; // 5MB
            if (file.size > maxSize) {
                alert("File size exceeds 5MB. Please select a smaller image.");
                imageInput.value = ""; // Clear the invalid input
                return;
            }

            // Create object URL for preview
            var url = URL.createObjectURL(file);
            document.getElementById("img_span_" + x).className = "d-none"; // Hide placeholder
            var imgPreview = document.getElementById("img_div_" + x);
            imgPreview.src = url;

            // Clean up the previous object URL when the image changes
            imgPreview.onload = function () {
                if (imgPreview.dataset.oldUrl) {
                    URL.revokeObjectURL(imgPreview.dataset.oldUrl);
                }
                imgPreview.dataset.oldUrl = url; // Store the current URL for cleanup
            };
        } else {
            alert("Please select an image.");
        }

        // Remove the event listener after handling the change event
        imageInput.removeEventListener("change", handleImageChange);
    });

}

function tUpdateImage(x) {
    var imageInput = document.getElementById("img_update_" + x);
    imageInput.click(); // Trigger the file input dialog

    imageInput.addEventListener("change", function handleImageChange() {
        var fileCount = imageInput.files.length;

        if (fileCount === 1) {
            var file = imageInput.files[0];

            // Validate file type
            var allowedTypes = ["image/jpg", "image/jpeg", "image/png", "image/webp"];
            if (!allowedTypes.includes(file.type)) {
                alert("Invalid file type. Please select a JPG, JPEG, PNG, or WEBP image.");
                imageInput.value = ""; // Clear the invalid input
                return;
            }

            // Validate file size (e.g., max 5MB)
            var maxSize = 5 * 1024 * 1024; // 5MB
            if (file.size > maxSize) {
                alert("File size exceeds 5MB. Please select a smaller image.");
                imageInput.value = ""; // Clear the invalid input
                return;
            }

            // Create object URL for preview
            var url = URL.createObjectURL(file);
            document.getElementById("update_span_" + x).className = "d-none"; // Hide placeholder
            var imgPreview = document.getElementById("update_div_" + x);
            imgPreview.src = url;

            // Clean up the previous object URL when the image changes
            imgPreview.onload = function () {
                if (imgPreview.dataset.oldUrl) {
                    URL.revokeObjectURL(imgPreview.dataset.oldUrl);
                }
                imgPreview.dataset.oldUrl = url; // Store the current URL for cleanup
            };
        } else {
            alert("Please select an image.");
        }

        // Remove the event listener after handling the change event
        imageInput.removeEventListener("change", handleImageChange);
    });
}

function cProductImage(cvn,x) {
    var imageInput = document.getElementById("img_input_" + cvn + x);
    imageInput.click(); // Trigger the file input dialog

    imageInput.addEventListener("change", function handleImageChange() {
        var fileCount = imageInput.files.length;

        if (fileCount === 1) {
            var file = imageInput.files[0];

            // Validate file type
            var allowedTypes = ["image/jpg", "image/jpeg", "image/png", "image/webp"];
            if (!allowedTypes.includes(file.type)) {
                alert("Invalid file type. Please select a JPG, JPEG, PNG, or WEBP image.");
                imageInput.value = ""; // Clear the invalid input
                return;
            }

            // Validate file size (e.g., max 5MB)
            var maxSize = 5 * 1024 * 1024; // 5MB
            if (file.size > maxSize) {
                alert("File size exceeds 5MB. Please select a smaller image.");
                imageInput.value = ""; // Clear the invalid input
                return;
            }

            // Create object URL for preview
            var url = URL.createObjectURL(file); // Hide placeholder
            var imgPreview = document.getElementById("img_div_" + cvn + x);
            imgPreview.src = url;

            // Clean up the previous object URL when the image changes
            imgPreview.onload = function () {
                if (imgPreview.dataset.oldUrl) {
                    URL.revokeObjectURL(imgPreview.dataset.oldUrl);
                }
                imgPreview.dataset.oldUrl = url; // Store the current URL for cleanup
            };
        } else {
            alert("Please select an image.");
        }

        // Remove the event listener after handling the change event
        imageInput.removeEventListener("change", handleImageChange);
    });
}


function changevm() {

    var vision_txt = document.getElementById("vision_txt").value;
    var mission_txt = document.getElementById("mission_txt").value;

    var r = new XMLHttpRequest();
    var form = new FormData();
    form.append("vision", vision_txt);
    form.append("mission", mission_txt);

    r.onreadystatechange = function () {
        if (r.readyState == 4 && r.status == 200) {
            alert(r.responseText);
        }
    }
    r.open("POST", "update-vm-process.php", true);
    r.send(form);

}

function AddDis() {
    // Get input values
    var dname = document.getElementById("dname").value.trim();
    var damount = document.getElementById("damount").value.trim();
    var dper = document.getElementById("dper").value.trim();

    // Create a new XMLHttpRequest object
    var r = new XMLHttpRequest();

    // Create a FormData object to send the data
    var form = new FormData();
    form.append("dname", dname);
    form.append("damount", damount);
    form.append("dper", dper);

    // Set up the response handler
    r.onreadystatechange = function () {
        if (r.readyState == 4 && r.status == 200) {
            var response = r.responseText;
            if (response == "success") {
                alert("Discount added");
                window.location.reload();  // Reload the page
            } else {
                alert(response);  // Show the response from the server
            }
        }
    };

    // Open a POST request to the target PHP file
    r.open("POST", "AddSingleDiscount.php", true);

    // Send the form data
    r.send(form);
}

function DelDis() {
    // Get the selected value from the ddelete selection
    var ddelete = document.getElementById("ddelete").value;

    // Validate if a value is selected (non-empty)
    if (ddelete === "") {
        alert("Please select a discount to delete.");
        return;
    }

    // Create a new XMLHttpRequest object
    var r = new XMLHttpRequest();

    // Create a FormData object to send the data
    var form = new FormData();
    form.append("ddelete", ddelete);

    // Set up the response handler
    r.onreadystatechange = function () {
        if (r.readyState == 4 && r.status == 200) {
            var response = r.responseText;
            alert(response);  // Show the response from the server

            if (response === "deleted") {
                window.location.reload();  // Reload the page if the deletion is successful
            }
        }
    };

    // Open a POST request to the target PHP file (deletedis.php)
    r.open("POST", "deletedis.php", true);

    // Send the form data
    r.send(form);
}

function SearchProduct() {
    var pkeyword = document.getElementById("pkey").value;
    var pview = document.getElementById("ProductResult");

    var x = new XMLHttpRequest();


    x.onreadystatechange = function () {
        if (x.readyState == 4 && x.status == 200) {
            var response = x.responseText;

            pview.innerHTML = response;



        }
    };
    x.open("GET", "SearchProductProcess.php?pkey=" + encodeURIComponent(pkeyword), true);
    x.send();
}



function change_branch() {

    var bid = document.getElementById("bid").value;
    var bname = document.getElementById("branch_name");
    var bnum = document.getElementById("branch_number");
    var baddress = document.getElementById("branch_address");

    var r = new XMLHttpRequest();
    var form = new FormData();
    form.append("bid", bid);

    r.onreadystatechange = function () {
        if (r.readyState == 4 && r.status == 200) {
            try {
                var jsonData = JSON.parse(r.responseText);
                var firstObject = jsonData[0];
                bname.value = firstObject.brc_name;
                bnum.value = firstObject.brc_num;
                baddress.value = firstObject.brc_address;
                return true;
            } catch (e) {
                alert(r.responseText);
                return false;
            }
        }
    }
    r.open("POST", "change-branch-process.php", true);
    r.send(form);

}

function list_dprice() {

    var cid = document.getElementById("c_id").value;
    var cid2 = document.getElementById("c_id2").value;
    var x = document.getElementById("d_price");

    var r = new XMLHttpRequest();
    var form = new FormData();
    form.append("cid", cid);
    form.append("cid2", cid2);

    r.onreadystatechange = function () {
        if (r.readyState == 4 && r.status == 200) {
            if (r.responseText == "Please select a city.") {
                x.value = null;
            } else if (r.responseText == "nc") {
                x.value = null;
            } else if (isNaN(r.responseText)) {
                x.value = null;
                alert(r.responseText);
            } else {
                x.value = r.responseText;
            }
        }
    }
    r.open("POST", "change-dcharge-process.php", true);
    r.send(form);

}

function list_town() {

    var did = document.getElementById("ad_id").value;

    var r = new XMLHttpRequest();
    var form = new FormData();
    form.append("did", did);

    r.onreadystatechange = function () {
        if (r.readyState == 4 && r.status == 200) {
            if (r.responseText == "Error") {
                document.getElementById("at_id").value = null;
            } else if (r.responseText == "Please select a ditsrict.") {
                document.getElementById("at_id").value = null;
            } else {
                document.getElementById("at_id").innerHTML = r.responseText;
            }
        }
    }
    r.open("POST", "change-city-process.php", true);
    r.send(form);

}

var town_col_count = 0;
function add_town_col() {
    var town_col = document.getElementById("town_col");
    if (town_col_count <= 5) {
        town_col_count = town_col_count + 1;
        town_col.innerHTML += "<div class='col-6 col-md-4'>" +
            "<div class='form-floating mb-3'>" +
            "<input type='text' class='form-control rounded-0' id='tc_" + town_col_count + "' value='' placeholder='charges'>" +
            "<label for=''>Town " + town_col_count + " name</label>" +
            "</div>" +
            "</div>";
    } else {
        alert("A maximum of six towns can be added at a time.");
    }


}

function add_new_town() {

    var did = document.getElementById("ad_id").value;

    var r = new XMLHttpRequest();
    var form = new FormData();
    form.append("did", did);

    var tnid = [];
    for (let i = 1; i <= town_col_count; i++) {
        tnid[i] = document.getElementById("tc_" + i).value;
        form.append("tnid" + i, tnid[i]);
    }
    form.append("town_col_count", town_col_count);

    r.onreadystatechange = function () {
        if (r.readyState == 4 && r.status == 200) {
            alert(r.responseText);
            if (r.responseText == "Towns added successfully !") {
                location.reload();
            }
        }
    }
    r.open("POST", "add-new-city-process.php", true);
    r.send(form);

}

function update_dprice() {

    var cid = document.getElementById("c_id").value;
    var cid2 = document.getElementById("c_id2").value;
    var d_price = document.getElementById("d_price").value;

    var r = new XMLHttpRequest();
    var form = new FormData();
    form.append("cid", cid);
    form.append("cid2", cid2);
    form.append("d_price", d_price);

    r.onreadystatechange = function () {
        if (r.readyState == 4 && r.status == 200) {
            alert(r.responseText);
            if (r.responseText == "Delivey charges updated.") {
                location.reload();
            }
        }
    }
    r.open("POST", "add-dcharge-process.php", true);
    r.send(form);

}

function update_branch() {

    var branch_id = document.getElementById("bid").value;
    var branch_name = document.getElementById("branch_name").value;
    var branch_number = document.getElementById("branch_number").value;
    var branch_address = document.getElementById("branch_address").value;

    var r = new XMLHttpRequest();
    var form = new FormData();
    form.append("branch_id", branch_id);
    form.append("branch_name", branch_name);
    form.append("branch_number", branch_number);
    form.append("branch_address", branch_address);

    r.onreadystatechange = function () {
        if (r.readyState == 4 && r.status == 200) {
            alert(r.responseText);
        }
    }
    r.open("POST", "update-branch-process.php", true);
    r.send(form);

}

function change_email() {

    var email = document.getElementById("contact_email").value;

    var r = new XMLHttpRequest();
    var form = new FormData();
    form.append("email", email);

    r.onreadystatechange = function () {
        if (r.readyState == 4 && r.status == 200) {
            alert(r.responseText);
        }
    }

    r.open("POST", "update-email-process.php", true);
    r.send(form);

}

function tBlogImage() {

    var image = document.getElementById("blog_img_input");
    image.click();

    image.onchange = function () {
        var file_count = image.files.length;
        if (file_count == 1) {
            var file = image.files[0];
            var url = window.URL.createObjectURL(file);
            document.getElementById("blog_img_span").className = "d-none";
            document.getElementById("blog_img_div").src = url;

        } else {
            alert("Please select an image.");
        }
    }

}

function add_new_blog() {

    var b_id = document.getElementById("b_id");
    var b_name = document.getElementById("b_name");
    var b_body = document.getElementById("b_body");
    var b_img = document.getElementById("blog_img_input");

    var r = new XMLHttpRequest();
    var form = new FormData();
    form.append("b_id", b_id.value);
    form.append("b_name", b_name.value);
    form.append("b_body", b_body.value);

    var image_file_count = b_img.files.length;
    if (image_file_count == 1) {
        form.append("b_img", b_img.files[0]);

        r.onreadystatechange = function () {
            if (r.readyState == 4 && r.status == 200) {
                alert(r.responseText);
                if (r.responseText == "New Blog added Successfully.") {
                    location.reload();
                }
            }
        }

        r.open("POST", "addblog-process.php", true);
        r.send(form);

    } else {
        alert("Please selct an image.");
    }

}

function addOrDeleteBlog() {

    var bid = document.getElementById("b_id");
    if (bid.value == 0) {
        document.getElementById("add_blog_div").className = "col-12";
        document.getElementById("delete_blog_div").className = "d-none";
    } else {
        document.getElementById("add_blog_div").className = "d-none";
        document.getElementById("delete_blog_div").className = "col-12 text-center";
    }
}

function delete_blog() {

    var bid = document.getElementById("b_id").value;

    var r = new XMLHttpRequest();
    var form = new FormData();
    form.append("b_id", bid);

    r.onreadystatechange = function () {
        if (r.readyState == 4 && r.status == 200) {

            if (r.responseText == "Blog Deleted Successfully") {
                location.reload();
            } else {
                alert(r.responseText);
            }

        }
    }

    r.open("POST", "delete-blog-process.php", true);
    r.send(form);

}

function tNewsImage() {

    var image = document.getElementById("news_img_input");
    image.click();

    image.onchange = function () {
        var file_count = image.files.length;
        if (file_count == 1) {
            var file = image.files[0];
            var url = window.URL.createObjectURL(file);
            document.getElementById("news_img_span").className = "d-none";
            document.getElementById("news_img_div").src = url;

        } else {
            alert("Please select an image.");
        }
    }

}

function add_new_news() {

    var n_id = document.getElementById("n_id");
    var n_name = document.getElementById("n_name");
    var n_body = document.getElementById("n_body");
    var n_img = document.getElementById("news_img_input");

    var r = new XMLHttpRequest();
    var form = new FormData();
    form.append("n_id", n_id.value);
    form.append("n_name", n_name.value);
    form.append("n_body", n_body.value);

    var image_file_count = n_img.files.length;
    if (image_file_count == 1) {
        form.append("n_img", n_img.files[0]);

        r.onreadystatechange = function () {
            if (r.readyState == 4 && r.status == 200) {
                alert(r.responseText);
                if (r.responseText == "New News added Successfully.") {
                    location.reload();
                }
            }
        }

        r.open("POST", "addnews-process.php", true);
        r.send(form);

    } else {
        alert("Please selct an image.");
    }

}

function addOrDeleteNews() {

    var nid = document.getElementById("n_id");
    if (nid.value == 0) {
        document.getElementById("add_news_div").className = "col-12";
        document.getElementById("delete_news_div").className = "d-none";
    } else {
        document.getElementById("add_news_div").className = "d-none";
        document.getElementById("delete_news_div").className = "col-12 text-center";
    }
}

function delete_news() {

    var nid = document.getElementById("n_id").value;

    var r = new XMLHttpRequest();
    var form = new FormData();
    form.append("n_id", nid);

    r.onreadystatechange = function () {
        if (r.readyState == 4 && r.status == 200) {

            if (r.responseText == "News Deleted Successfully") {
                location.reload();
            } else {
                alert(r.responseText);
            }

        }
    }

    r.open("POST", "delete-news-process.php", true);
    r.send(form);

}

function triggerFileInput() {
    document.getElementById('newsFileInput').click();
}

function update_product_real(pid) {
    var pt = document.getElementById(pid + "pt");
    var pc = document.getElementById(pid + "pc");
    var pm = document.getElementById(pid + "pm");
    var pld = document.getElementById(pid + "pld");
    var img_input1 = document.getElementById("img_input_1" + pid);
    var img_input2 = document.getElementById("img_input_2" + pid);
    var img_input3 = document.getElementById("img_input_3" + pid);

    // Declare the FormData object before using it
    var form = new FormData();

    if (img_input1) {
        if (img_input1.files.length > 0) {
            form.append("img1", img_input1.files[0]); // Include the image file
        }
    }
    if (img_input2) {
        if (img_input2.files.length > 0) {
            form.append("img2", img_input2.files[0]); // Include the image file
        }
    }
    if (img_input3) {
        if (img_input3.files.length > 0) {
            form.append("img3", img_input3.files[0]); // Include the image file
        }
    }

    // Append other form data
    form.append("pid", pid);
    form.append("pc", pc.value);
    form.append("pm", pm.value);
    form.append("pt", pt.value);
    form.append("pld", pld.value);

    var r = new XMLHttpRequest();
    r.onreadystatechange = function () {
        if (r.readyState == 4 && r.status == 200) {
            alert(r.responseText);
            if (r.responseText == 'Product has been updated.') {
                window.location.reload();
            }
        }
    };

    r.open("POST", "update-product-real-process.php", true);
    r.send(form);
}


function disablePr(x, y) {

    var r = new XMLHttpRequest();
    var form = new FormData();
    form.append("pid", x);
    form.append("s", y);
    r.onreadystatechange = function () {
        if (r.readyState == 4 && r.status == 200) {
            alert(r.responseText);
            if (r.responseText == 'Product status updated.') {
                window.location.reload();
            }
        }
    }

    r.open("POST", "update-product-status.php", true);
    r.send(form);

}


function update_product(pid, bid) {
    var pb = document.getElementById(String(pid) + String(bid) + "pb");
    var pp = document.getElementById(String(pid) + String(bid) + "pp");

    var r = new XMLHttpRequest();
    var form = new FormData();
    form.append("pid", pid);
    form.append("bid", bid);
    form.append("pb", pb.value);
    form.append("pp", pp.value);

    r.onreadystatechange = function () {
        if (r.readyState == 4 && r.status == 200) {
            alert(r.responseText);
            if (r.responseText == 'Variation has been updated.') {
                window.location.reload();
            }
        }
    }

    r.open("POST", "update-product-process.php", true);
    r.send(form);

}

function AddVar() {
    var vn = document.getElementById('addvname');
    var vb = document.getElementById('addvbox');
    var vp = document.getElementById('addvprice');

    var r = new XMLHttpRequest();
    var form = new FormData();
    form.append("vp", vp.value);
    form.append("vn", vn.value);
    form.append("vb", vb.value);

    r.onreadystatechange = function () {
        if (r.readyState == 4 && r.status == 200) {
            alert(r.responseText);
            if (r.responseText == 'Variation has been updated.') {
                window.location.reload();
            }
        }
    }

    r.open("POST", "add-var-process.php", true);
    r.send(form);

}

function OrderStatusSave(pid, mid) {
    var name = "statusChangeProduct" + mid + "3";
    var status = document.getElementById(name);

    var x = new XMLHttpRequest();

    var form = new FormData();
    form.append("pid", pid);
    form.append("sid", status.value);


    x.onreadystatechange = function () {
        if (x.readyState == 4 && x.status == 200) {
            var response = x.responseText;
            if (response === "success") {
                window.location.reload();
            } else {
                alert(response);
            }
        }
    };
    x.open("POST", "ChangeOrderStatusProcess.php", true);
    x.send(form);
}

function userblockandunblcok(ue, st) {

    var x = new XMLHttpRequest();

    var form = new FormData();
    form.append("ue", ue);
    form.append("st", st);


    x.onreadystatechange = function () {
        if (x.readyState == 4 && x.status == 200) {
            var response = x.responseText;
            alert(response);
            if (response == "User status changed.") {
                window.location.reload();
            } else {
                alert(response);
            }
        }
    };
    x.open("POST", "ChangeUserStatusProcess.php", true);
    x.send(form);
}

function SearchUser() {
    var ukeyword = document.getElementById("ukey").value;
    var uview = document.getElementById("userarea");

    var x = new XMLHttpRequest();


    x.onreadystatechange = function () {
        if (x.readyState == 4 && x.status == 200) {
            var response = x.responseText;

            uview.innerHTML = response;



        }
    };
    x.open("GET", "SearchUserProcess.php?ukey=" + encodeURIComponent(ukeyword), true);
    x.send();
}

function SearchInvoice() {
    var keyword = document.getElementById("keyword").value;
    var view = document.getElementById("UserResult");

    var x = new XMLHttpRequest();


    x.onreadystatechange = function () {
        if (x.readyState == 4 && x.status == 200) {
            var response = x.responseText;

            view.innerHTML = response;



        }
    };
    x.open("GET", "SearchInvoiceProcess.php?key=" + encodeURIComponent(keyword), true);
    x.send();

}

function AddCategory() {
    var cname = document.getElementById("cname").value;

    var x = new XMLHttpRequest();


    x.onreadystatechange = function () {
        if (x.readyState == 4 && x.status == 200) {
            var response = x.responseText;
            if (response === "success") {
                window.location.reload();
            } else {
                alert(response);
            }
        }
    };
    x.open("GET", "AddCategoryProcess.php?cname=" + encodeURIComponent(cname), true);
    x.send();
}

function AddMeat() {
    var cname = document.getElementById("wname").value;

    var x = new XMLHttpRequest();


    x.onreadystatechange = function () {
        if (x.readyState == 4 && x.status == 200) {
            var response = x.responseText;
            if (response === "success") {
                window.location.reload();
            } else {
                alert(response);
            }
        }
    };
    x.open("GET", "AddWeightProcess.php?cname=" + encodeURIComponent(cname), true);
    x.send();
}

function addProduct() {
    var title = document.getElementById("title");
    var sd = document.getElementById("sd");
    var c = document.getElementById("category");
    var weight = document.getElementById("weight");
    var image1 = document.getElementById("img_input_1");
    var image2 = document.getElementById("img_input_2");
    var image3 = document.getElementById("img_input_3");

    var f = new FormData();

    f.append("t", title.value);
    f.append("cat", c.value);
    f.append("weight", weight.value);
    f.append("s_des", sd.value); // Corrected from innerHTML to value
    f.append("img1", image1.files[0]); // Corrected from files["0"] to files[0]
    f.append("img2", image2.files[0]);
    f.append("img3", image3.files[0]);

    var r = new XMLHttpRequest();

    r.onreadystatechange = function () {
        if (r.readyState == 4) { // Ensures request is complete
            if (r.status == 200) { // Checks for success
                var response = r.responseText;

                if (response == "success") {
                    alert("Product Added Successfully");
                    window.location.reload();
                } else {
                    alert(response);
                }
            } else {
                console.error("Error with the request:", r.status);
            }
        }
    };

    r.open("POST", "addProductProcess.php", true);
    r.send(f);
}


function adminLogin() {
    var username = document.getElementById("u");
    var password = document.getElementById("password");

    var form = new FormData();
    form.append("u", username.value);
    form.append("p", password.value);

    var x = new XMLHttpRequest();


    x.onreadystatechange = function () {
        if (x.readyState == 4 && x.status == 200) {
            var response = x.responseText;
            if (response === "success") {
                window.location = "admin.php";
            } else {
                alert(response);
            }
        }
    };

    x.open("POST", "adminLoginprocess.php", true);
    x.send(form);
}

function admin_logout() {
    var r = new XMLHttpRequest();
    r.onreadystatechange = function () {
        if (r.readyState == 4 && r.status == 200) {
            if (r.responseText == "done") {
                window.location.href = "authentication-login.php";
            } else if (r.responseText == "Something went wrong !") {
                location.reload();
            }
        }
    }

    r.open("POST", "admin-logout.php", true);
    r.send();
}

