
// test table link ---------- https://docs.google.com/spreadsheets/d/1SZQTNIczgTDBrOS4X3nvgaVSetxeMWuam7ASxghJ3Js/edit#gid=0

$( document ).ready(function() {
    let wpcf7Elm = $( '#wpcf7-f396-p399-o1' );

    wpcf7Elm.on('wpcf7mailsent', function() {
        let arrayForm = wpcf7Elm.children('.wpcf7-form').serializeArray();
        let sendObject = {};
        let url = 'https://script.google.com/macros/s/AKfycbwqkwPctfkWPfBlKyULhrHg8PlBuR1UacV1pF399QZkrTouYZDv/exec';

        sendObject.typ_av_tak = arrayForm[5].value;
        sendObject.consumption = arrayForm[6].value;
        sendObject.installation = arrayForm[7].value;
        sendObject.full_name = arrayForm[8].value;
        sendObject.adress = arrayForm[9].value;
        sendObject.city = arrayForm[10].value;
        sendObject.email = arrayForm[11].value;
        sendObject.tel = arrayForm[12].value;
        
        $.ajax({
            url: url,
            method: "GET",
            dataType: "json",
            data: sendObject,
            }).done(function (data) {
                console.log('true'); 
            })
    });
});



