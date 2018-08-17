import axios from 'axios';

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
        return axios.get(this.baseurl+'/hello', { headers: { Authorization: AuthStr } });
    }

    getCreneaux(){
        return axios.get(this.baseurl+'/creneaux/all').then(response =>{        
           return response.data;      
        })
    }   

    getListCreneaux(){
        return axios.get(this.baseurl+'/creneaux/list').then(response =>{        
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

    postEmailCreneau(mail) {
        return axios.post(this.baseurl+'/creneaux/mail',mail).then(response =>{        
            return response.data;      
         })
    }

     isRegister(isregister) {
        return axios.get(this.baseurl+'/test.php/register',{withCredentials: true}).then(response =>{        
            return response.data;      
         })
     }

     postLogin(login) {
        return axios.post(this.baseurl+'/test.php/register',login,{withCredentials: true}).then(response =>{        
            return response.data;      
         })
     }


}

  