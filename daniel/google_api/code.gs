function updateTitleRow(sheetName, objectKeys){
  //var sheetName = "Sheet1";
  //var objectKeys = ['name', 'email', 'mobile'];
  
  var spreadSheet = SpreadsheetApp.getActiveSpreadsheet();
  var sheet = spreadSheet.getSheetByName(sheetName);
  
  var firstRow = sheet.getDataRange().getValues()[0];
  if(parseInt(firstRow.length) < parseInt(objectKeys.length)){
    Logger.log("Editing First Row");
    for(var i = 0; i < objectKeys.length; i++)
      sheet.getRange(1, i+1).setValue(objectKeys[i]);
  }
}
function submitForm(data){
  
  var spreadSheet = SpreadsheetApp.getActiveSpreadsheet();
  var sheet = spreadSheet.getSheetByName(data.sheet);

  if(!sheet) throw new Error("Invalid Sheet");
 
  
  var jsonData = {};
  
  var formData = data.data;
  var entries = formData.split("&");
 
  for(var i = 0; i < entries.length; i++){
    
    var entry = entries[i];
    var s = entry.split("=");
    jsonData[s[0]] = s[1];
    
  }
  
  var firstRow = sheet.getRange('A1').getValue();
  //Logger.log("Max Rows New" + firstRow.length);

  var totalEntries = Object.keys(jsonData);
  var newRow = [];
  for(var i=0; i<totalEntries.length; i++){
     newRow.push(decodeURI(jsonData[totalEntries[i]])); 
  }
  
  if(firstRow.length < 1){
    
    sheet.getRange(1, 1, 1, sheet.getMaxColumns()).setFontWeight("bold");
    sheet.appendRow(Object.keys(jsonData));
    
  }else{
  
    // Update Title Row
    var keysRange = Object.keys(jsonData);
    var firstRowRange = sheet.getDataRange().getValues()[0];
    
    sheet.getRange(1, 1, 1, sheet.getMaxColumns()).setFontWeight("bold");
    Logger.log("Keys Range : " + keysRange + " - First Row : " + firstRowRange);
    
    var editTitle = false;
    for(var i = 0; i < firstRowRange.length; i++) {
      if(firstRowRange[i].length < 2) editTitle = true;
    }
    
    if(parseInt(firstRowRange.length) < parseInt(keysRange.length) || editTitle){
      Logger.log("Editing First Row");
      for(var i = 0; i < keysRange.length; i++){
        sheet.getRange(1, i+1).setValue(keysRange[i])
      }
    }else{
      Logger.log("No First Row");
    }
    
  }
  
    
  
  
  
  
  //Logger.log(JSON.stringify(jsonData));
  sheet.insertRowsAfter(sheet.getMaxRows(), 1);
  sheet.appendRow(newRow);
  
  
   
  return true;
}

function doGet(e){
  return HtmlService
    .createHtmlOutputFromFile('index')
    .setXFrameOptionsMode(HtmlService.XFrameOptionsMode.ALLOWALL);
}