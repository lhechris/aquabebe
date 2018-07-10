import axios, { AxiosInstance, AxiosRequestConfig, AxiosError, AxiosResponse, AxiosStatic } from 'axios';
import moment from 'moment'

export class restapi {
    baseurl= 'http://localhost:85/rest';
    //baseurl='/rest';
    token = "";    

    getAdherents(){
        return axios.get(this.baseurl+'/adherents/current').then(response =>{        
           return response.data;      
        })
    }   

    postAdmin(){
        return axios.post(this.baseurl+'/token').then(response=>{
            this.token=response.data;
            console.log("token:"+this.token);
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

  