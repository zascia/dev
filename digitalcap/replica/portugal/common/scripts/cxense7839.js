//Function used to set a cookie in the browser
function createCookie(name, value, days) {
    var expires = "";
    if (days) {
        var date = new Date();
        date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
        expires = "; expires=" + date.toUTCString();
    }
    document.cookie = name + "=" + value + expires + "; path=/";
}

//Function that generates a UID<64 characters and set a cookie in the browser with the new UID
var cX = cX || {}; cX.callQueue = cX.callQueue || [];
var persistedQueryId = "f9b51e4f5d29059c5097df918688eadc4700ca18";
function logCxenseEvent(event, parameters) {
        cX.callQueue.push(["sendEvent",event , parameters, {origin: "pmp-gigya", persistedQueryId: persistedQueryId}]);    

}

function cxenseOnLoginHandler(eventObj) {
    // create a separate UID for cxense that is always less than 64 characters in length
    if (eventObj.data.cxenseID) { // if the cxenseID is available in custom data field
        var cxenseID = eventObj.data.cxenseID;
    } else { // if the cxenseID is not yet set in custom data field, so do that now
        if (eventObj.UID.length > 64) { // if the Gigya UID is longer than 64 characters
            var cxenseID = eventObj.signatureTimestamp + eventObj.UID.substring(6, 64); // use the timestamp and UID without leading "_guid_"
            cxenseID = cxenseID.substring(0, 64); // trim to less than 64 chars
        } else { // use the Gigya UID if 64 chars or less
            var cxenseID = eventObj.UID;
        }
        // set the cxenseID in the custom data field once
        gigya.accounts.setAccountInfo({ data: { cxenseID: cxenseID }, callback: setAccountInfoResponse });
    }

    createCookie('gig_cxenseID', cxenseID, 60);
    logCxenseEvent("login", { cxenseID: cxenseID});
}

//Display any errors from Gigya accounts.setAccountInfo() set of data.cxenseID
function setAccountInfoResponse(response) {
    if (response.errorCode !== 0) {
        console.log('Gigya setAccountInfo error: ' + JSON.stringify(response, null, 2));
        logCxenseEvent("setAccountInfoError", { errorCode: response.errorCode});
    }
}

/*
logCxenseEvent("error", { errorCode: 100});
*/