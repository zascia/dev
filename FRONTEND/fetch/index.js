function sendAJAX(options) {
    let method = options.method;
    let headersData = options.headers;
    /*if (options.headers) {
        let headersRaw = new Map(options.headers);
        let headers = {}
        for (let [key,value] of headersRaw) {
            headers.key = value;
        }
    }*/
    paramsObj = {
        headers: options.headers,
        method: options.method
    }
    if (options.body) {
        paramsObj.body = options.body;
    }

    fetch(options.urlpath, paramsObj)
    .then(response => {
        if (response.status !== 200) {
            return Promise.reject(new Error(`${response.status} + ${response.statusText}`))
        }
        return Promise.resolve(response)
    })
    .then(response => {
        return response.json()
    })
    .then(data => {
        console.log("data", data);
    })
    .catch(error => {
        console.log("error",error)
    });



    /*if (count(json_decode(response)) > 0) {
        $contactList = $response;
        break;
    }*/
}

function getUserFromGetResposne(token, email) {
    //user special data
    let headers = {};
    headers["x-auth-token"] = "api-key 98e9893f951367413bd5204890473ba0";
    //headers.push(["x-auth-token","api-key 98e9893f951367413bd5204890473ba0"]);

    // common function data
    let options = {}
    options.method = 'GET';
    options.urlpath = `https://api.getresponse.com/v3/contacts?query[campaignId]=${token}&query[email]=${email}`;
    options.headers = headers;

    sendAJAX(options);

}

function getUserFromSalus(email) {
    let salusAPIURL = 'https://api.salus.group/api/';
    const params = new URLSearchParams({
        apikey: 'p-2818-kjyu38d9snm3ks8',
        version: 'v1',
        function: 'checkuser',
        countrycode: 'dk',
        parenturl: 'https://ellafinans.dk',
        email: email
    });
    let paramstring = params.toString();

    let options = {}
    options.method = 'GET';
    options.urlpath = `${salusAPIURL}?${paramstring}`;
    options.headers = {}

    response = sendAJAX(options);
    console.log("response",response);
}

function getUsersFromLivalaan() {
    let options = {}
    options.method = 'GET';
    options.urlpath = 'https://livalaan.dk/wp-admin/admin-ajax.php?action=extractusers';
    options.headers = {}

    response = sendAJAX(options);
    console.log("response",response);
}

function sendPOSTFormURLEncoded() {
    let options = {}
    options.method = 'POST';
    options.urlpath = 'facebookAPI_path';
    options.headers = {
        'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8'
    }
    options.body = new URLSearchParams({
        'userName': 'test@gmail.com',
        'password': 'Password!',
        'grant_type': 'password'
    })

    /*var data = new URLSearchParams();
    data.append('userName', 'test@gmail.com');
    data.append('password', 'Password');
    data.append('grant_type', 'password');*/
}

// prepare getresponse data and call getresponse API
let token = '8xFM8';
let email = 'zascia@ukr.net';

//if (token && email) getUserFromGetResposne(token, email);
//if (email) getUserFromSalus(email);

getUsersFromLivalaan();




