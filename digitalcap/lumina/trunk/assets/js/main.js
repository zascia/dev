Vue.use(VueFormWizard)

new Vue({
    el: '#form',
    components: {
        
    },
    data:{
        selected: 'lessYear',
        parA: '',
        fields: {       
            Email: '',
            EmailRef: '',
            Name: '',
            AccountAge: '',
            HowOften: 'lessYear',
            FBLink: '',
            Device: '',
            FBBrowser: '',
            Business: '',
            Status: 'Lead'
        },
        sendFields: {}
    },
    methods: {
        onComplete: function(){
            this.sendFields.fields= this.fields;
            let parametherA = this.parA;
            $.ajax({
                url: 'api/airtable.php',
                type: 'post',
                dataType: 'json', 
                data: JSON.stringify(this.sendFields),
                success: function(data2) {
                    if(data2.id == undefined){
                        document.getElementById('form').style.border = "1px solid red";
                    }
                    else{
                        if( parametherA == ''){
                            window.location.href ="thanks.php"                     
                        }
                        else{
                            window.location.href ="thanks.php?a=" + parametherA;
                        }
                    }
                },
                error: function(data){
                    document.getElementById('form').style.border = "1px solid red";
                }
            });
            
        },
        checkFirstStep: function (event) {
            event.preventDefault();
            let email = document.getElementById('email');
            let name = document.getElementById('name');
            var regEmail = /^\w+@\w+\.\w{2,4}$/i;
            if(regEmail.test(email.value) && name.value.length >= 2){
                this.fields.Email = email.value;
                this.fields.Name = name.value;
                this.$refs.wizard.nextTab();
            }
            else{
                if(!regEmail.test(email.value)){
                    email.style.border = "2px solid red";
                }
                else if(name.value.length < 2){
                    name.style.border = "2px solid red";
                }
            }
        },
        onChange(event) {
            this.$refs.wizard.nextTab();
        }
    },
    created()
    {
        let uri = window.location.href.split('?');
        if (uri.length == 2)
        {
        let vars = uri[1].split('&');
        let getVars = {};
        let tmp = '';
        vars.forEach(function(v){
            tmp = v.split('=');
            if(tmp.length == 2)
            getVars[tmp[0]] = tmp[1];
        });
            this.fields.EmailRef = getVars.email;
            this.parA =  getVars.a;
        }
    },
})