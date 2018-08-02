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
        //console.log("getHello");
        return axios.get(this.baseurl+'/hello', { headers: { Authorization: AuthStr } })
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


}

  