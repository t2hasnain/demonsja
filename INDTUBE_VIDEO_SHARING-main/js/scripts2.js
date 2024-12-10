function processExcelData() 
{
    var fileInput = document.getElementById('fileToUpload');
    var file = fileInput.files[0];
    var reader = new FileReader();

    reader.onload = function (e) 
    {
        var data = new Uint8Array(e.target.result);
        var workbook = XLSX.read(data, { type: 'array' });
        var sheet = workbook.Sheets[workbook.SheetNames[0]];
        var jsonData = XLSX.utils.sheet_to_json(sheet, { header: 1 });

        var jsonDataString = JSON.stringify(jsonData);
        document.getElementById('jsonData').value = jsonDataString;

        document.getElementById('uploadForm').submit();
    };

    reader.readAsArrayBuffer(file);
}
function displayFileName() {
    var fileInput = document.getElementById('fileToUpload');
    var fileNameDisplay = document.getElementById('fileName');
    if (fileInput.files.length >0) 
    {
        fileNameDisplay.textContent = 'Uploaded file: ' + fileInput.files[0].name;
    } else 
    {
        fileNameDisplay.textContent = '';
    }
}
