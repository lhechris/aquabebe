import axios from 'axios';

export class restapi {
    baseurl= 'http://localhost/rest';
    //baseurl='/rest';
    token = "";    

    getAdherents(saison){
        return axios.get(this.baseurl+'/adherents/'+saison).then(response =>{        
           return response.data;      
        })
    }   

    getSaison(){
        return axios.get(this.baseurl+'/saison/current').then(response =>{        
           return response.data;      
        })
    }   
    getAllSaison(){
        return axios.get(this.baseurl+'/saison/all').then(response =>{        
           return response.data;      
        })
    }   
    postSaison(saison){
        return axios.post(this.baseurl+'/saison/'+saison).then(response=>{
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

    getCreneaux(saison){
        return axios.get(this.baseurl+'/creneaux/listwithpreinscrit/'+saison).then(response =>{        
           return response.data;      
        })
    }   

    getCreneau(creneauid){
        return axios.get(this.baseurl+'/creneaux/id='+creneauid).then(response =>{        
           return response.data;      
        })
    }   
    getListCreneaux(saison){
        return axios.get(this.baseurl+'/creneaux/list/'+saison).then(response =>{        
           return response.data;      
        })
    }   

    getEnfant(id){
        return axios.get(this.baseurl+'/enfant/'+id).then(response =>{        
           return response.data;      
        })
    }   

    postEnfant(enfant) {
        return axios.post(this.baseurl+'/enfant/profile',enfant).then(response =>{        
            return response.data;      
         })
     }

     postValiderCreneau(data) {
        return axios.post(this.baseurl+'/enfant/creneau',data).then(response =>{        
            return response.data;      
         })
     }

    postEmailCreneau(mail) {
        return axios.post(this.baseurl+'/creneaux/mail',mail).then(response =>{        
            return response.data;      
         })
    }

     isRegister() {
        return axios.get(this.baseurl+'/register/is',{withCredentials: true}).then(response =>{        
            return response.data;      
         })
     }

     postLogin(login) {
        return axios.post(this.baseurl+'/register',login,{withCredentials: true}).then(response =>{        
            return response.data;      
         })
     }
     postLogout() {
        return axios.post(this.baseurl+'/unregister',).then(response =>{        
            return response.data;      
         })
     }
     
     getDocuments() {
        return axios.get(this.baseurl+'/doc/get').then(response =>{        
            return response.data;      
         })
     }
     getDocument(id) {
        return axios.get(this.baseurl+'/doc/getfichier/'+id,{responseType:'stream'}).then(response =>{      
            return response; 
         })
     }

     postDocUpload(data) {
        return axios.post(this.baseurl+'/doc/upload',data).then(response =>{        
            return response.data;      
         })
    }
    postDocUpdate(data) {
        return axios.post(this.baseurl+'/doc/update',data).then(response =>{        
            return response.data;      
         })
    }
    getPage(name) {
        return axios.get(this.baseurl+'/pages/name='+name).then(response =>{      
            return response.data; 
         })
     }
     getListPages() {
        return axios.get(this.baseurl+'/pages/list').then(response =>{      
            return response.data; 
         })
     }
     postPageUpdate(data) {
        return axios.post(this.baseurl+'/pages/update',data).then(response =>{        
            return response.data;      
         })
    }

    postCertificat(data) {
        return axios.post(this.baseurl+'/enfant/certificat/'+data).then(response =>{        
            return response.data;      
         })
    }
    postVaccins(data) {
        return axios.post(this.baseurl+'/enfant/vaccins/'+data).then(response =>{        
            return response.data;      
         })
    }
    postFacture(data) {
        return axios.post(this.baseurl+'/enfant/facture/'+data).then(response =>{        
            return response.data;      
         })
    }

    postNewCreneau(data) {
        return axios.post(this.baseurl+'/creneaux/add',data).then(response => {
            return response.data;
        })
    }

    getLockInscription() {
        return axios.get(this.baseurl+'/inscription/lock').then(response => {
            return response.data;
        })
    }
    postLockInscription(data) {
        return axios.post(this.baseurl+'/inscription/lock',data).then(response => {
            return response.data;
        })        
    }

    getReservations() {
        return axios.get(this.baseurl+'/inscription/reservations').then(response => {
            return response.data;
        })        
    }


}

  