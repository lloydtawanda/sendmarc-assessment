<!DOCTYPE html>
<html>
<head>
    <title>Tasks</title>
</head>
<body>
<div>
<table>
    <tr>
        <td>Name:</td>
        <td><input type="text" id="name"></td>
    </tr>
    <tr>
        <td>Priority:</td>
        <td><input type="text" id="name"></td>
    </tr>
    <tr>
        <td>Due Date:</td>
        <td><input type="text" id="age">
            <input type="button" id="add" value="Add" onclick="Javascript:addRow()"></td>
    </tr>
    <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
    </tr>
</table>
</div>
<div id="mydata">
    <b>Current data in the system ...</b>
    <table id="myTableData"  border="1" cellpadding="2">
        <tr>
            <td>&nbsp;</td>
            <td><b>Name</b></td>
            <td><b>Age</b></td>
        </tr>
    </table>
    &nbsp;

</div>
<div id="myDynamicTable">
    <input type="button" id="create" value="Click here" onclick="Javascript:addTable()">
    to create a Table and add some data using JavaScript
</div>
<script type="application/javascript">
    function addRow() {

        var myName = document.getElementById("name");
        var age = document.getElementById("age");
        var table = document.getElementById("myTableData");

        var rowCount = table.rows.length;
        var row = table.insertRow(rowCount);

        row.insertCell(0).innerHTML= '<input type="button" value = "Delete" onClick="Javacsript:deleteRow(this)">';
        row.insertCell(1).innerHTML= myName.value;
        row.insertCell(2).innerHTML= age.value;

    }

    function deleteRow(obj) {

        let index = obj.parentNode.parentNode.rowIndex;
        let table = document.getElementById("myTableData");
        table.deleteRow(index);

    }

    function addTable() {

        let myTableDiv = document.getElementById("myDynamicTable");

        let table = document.createElement('TABLE');
        table.border='1';

        let tableBody = document.createElement('TBODY');
        table.appendChild(tableBody);

        for (let i=0; i<3; i++){
            let tr = document.createElement('TR');
            tableBody.appendChild(tr);

            for (let j=0; j<4; j++){
                let td = document.createElement('TD');
                td.width='75';
                td.appendChild(document.createTextNode("Cell " + i + "," + j));
                tr.appendChild(td);
            }
        }
        myTableDiv.appendChild(table);

    }

    function load() {

        console.log("Page load finished");

    }
</script>
</body>
</html>
