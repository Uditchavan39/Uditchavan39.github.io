
function addRowHandlers() {
  test = document.getElementById("mytable");
  var rows = test.getElementsByTagName("tr");
  for (i = 0; i < rows.length; i++) {
    var currentRow = test.rows[i];
    var createClickHandler = function (row) {
      return function () {
        var cell = row.getElementsByTagName("td")[0];
        var id = cell.innerHTML;
        document.location.href = "index.php?name="+id;
        console.log(id);
      };
    };
    currentRow.onclick = createClickHandler(currentRow);
  }
}
function transaction(){
  var value =document.getElementById("input-amount").value;
   // alert("Enter Valid Amount!");
 if(value=="" || value==0)
   alert("Enter a Valid Amount.");
   else
    document.forms["client_name"].submit();
}

document.getElementById("input-amount").oninput = function () {
  var max = parseInt(this.max);

  if (parseInt(this.value) > max) {
      this.value = max; 
  }
  
}
