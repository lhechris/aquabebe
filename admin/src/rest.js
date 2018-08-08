import axios,{AxiosRequestConfig} from 'axios';

var ajaxTimeout = 30000; // in milliseconds
export class restapi {
    baseurl= 'http://localhost:85/rest';
    //baseurl='/rest';
    token = "";    

    getAdherents(){
        return axios.get(this.baseurl+'/adherents/current').then(response =>{        
           return response.data;      
        })
    }   

    getSaison(){
        return axios.get(this.baseurl+'/saison').then(response =>{        
           return response.data;      
        })
    }   

    postAdmin(){
        return axios.post(this.baseurl+'/token').then(response=>{
            this.token=response.data;
            //console.log("token:"+this.token);
        })
    }
    
    getHello(){
        const AuthStr = 'Bearer '.concat(this.token); 
        //console.log("getHello");
        return axios.get(this.baseurl+'/hello', { headers: { Authorization: AuthStr } })
/* res.header('Access-Control-Allow-Origin', yourExactHostname);
  res.header('Access-Control-Allow-Credentials', true);
  res.header('Access-Control-Allow-Headers', 'Origin, X-Requested-With, Content-Type, Accept');
 */

         /*.then(response => {
             console.log(response.data);
          })
         .catch((error) => {
             console.log('error ' + error);
          })*/;
    }

    getCreneaux(){
        return axios.get(this.baseurl+'/creneaux/all').then(response =>{        
           return response.data;      
        })
    }   

    getEnfant(id){
        return axios.get(this.baseurl+'/enfant/'+id).then(response =>{        
           return response.data;      
        })
    }   

    postEnfant(enfant) {
        return axios.post(this.baseurl+'/enfant',enfant).then(response =>{        
            return response.data;      
         })
     }

     isRegister(isregister) {
        return axios.get(this.baseurl+'/test.php/register',{withCredentials: true}).then(response =>{        
            return response.data;      
         })
         /*$.ajax({
            url: this.baseurl+'/test.php/register',
            type: 'GET',
            async: true,
            timeout: ajaxTimeout,
            xhrFields: {
                withCredentials: true,
                "Access-Control-Allow-Origin" : "localhost",
           },
            success: function(data,textStatus,transport){
                isregister=data;
                console.log(data);
            }
        }
        );*/

     }

     postLogin(login) {
        return axios.post(this.baseurl+'/test.php/register',login,{withCredentials: true}).then(response =>{        
            return response.data;      
         })
     }


}

  