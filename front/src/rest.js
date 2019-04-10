import axios, { AxiosInstance, AxiosRequestConfig, AxiosError, AxiosResponse, AxiosStatic } from 'axios';
import moment from 'moment'

export class restapi {
    baseurl= '/rest';
    //baseurl='http://localhost/rest';
    token = "";    

    getPage(name) {
      
     return axios.get(this.baseurl+'/pages/name='+name).then(response =>{        
        return response.data;      
     })
    }
    
    getCreneaux(){
        return axios.get(this.baseurl+'/creneaux/all/current').then(response =>{        
           return response.data;      
        })
    }   

    getCreneauxForNaissance(naissance){
        return axios.get(this.baseurl+'/creneaux/naissance='+moment(naissance).format('YYYY-MM-DD')).then(response =>{        
           return response.data;      
        })
    }   

    postInscription(inscription) {
        console.log(inscription);
        return axios.post(this.baseurl+'/inscription',inscription).then(response =>{        
            console.log("postInscription:"+response);
            return response.data;      
         })
     }
     getIsInscriptionLocked() {
        return axios.get(this.baseurl+'/inscription/islock').then(response => {
            return response.data;
        })
    }
    unlockInscription(data) {
        return axios.post(this.baseurl+'/inscription/login',data).then(response => {
            return response.data;
        })
    }

    postAdmin(){
        return axios.post(this.baseurl+'/token').then(response=>{
            this.token=response.data;
            console.log("token:"+this.token);
        })
    }
    getSaison(){
        return axios.get(this.baseurl+'/saison/current').then(response =>{        
           return response.data;      
        })
    }  
    getHello(){
        const AuthStr = 'Bearer '.concat(this.token); 
        console.log("getHello");
        return axios.get(this.baseurl+'/hello', { headers: { Authorization: AuthStr } })
         .then(response => {
             console.log(response.data);
          })
         .catch((error) => {
             console.log('error ' + error);
          });
    }
}

  