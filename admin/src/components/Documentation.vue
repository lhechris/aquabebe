<template>
<div class="container">
    <p>Documentation</p>
    <div class="row">
        <div v-if="waiting">On recherche les documents....</div>
        <table style="text-align:left" v-else>
            <tr><th>Nom</th><th colspan="2">Description</th>
            <tr v-for="doc in documents">
                <td>{{doc.nom}}</td>
                <td>{{doc.description}}</td>
                <!--<td><button class="glyphicon glyphicon-download" v-on:click="download(doc.id)" /></td>-->
                <td><a class="glyphicon glyphicon-download" target="_blank" v-bind:href="'http://localhost:85/rest/doc/getfichier/'+doc.id" /></td>
            </tr>
        </table>
    </div>
    <div class="row mt-3" v-if="uploading">
        Transfert du fichier ....
    </div>
    <div class="row mt-3" v-else-if="newfile">
        <div class="row col-md-6">
        <table class="col-md-12">
            <tr><th>Fichier</th><th>Description</th></tr>
            <tr v-for="f in files">
                <td>{{f.obj.name}}</td>
                <td><input type="text" size="40" v-model="f.description"/></td>
            </tr>
        </table>
        </div>
        <div class="row col-md-7">
            <button type="button" class="btn btn-primary col-md-3" v-on:click="uploadfichier()" >Transferer</button>
            <span class="col-md-3" />
            <button type="button" class="btn btn-primary col-md-3" v-on:click="annuler()" >Annuler</button>
        </div>
    </div>        
    <div class="row mt-3" v-else>
        <input  type="file" id="files" ref="addfichier" v-on:change="handlefichier()"/>
        <button type="button" class="btn btn-primary col-md-2" v-on:click="$refs.addfichier.click()">Ajouter un fichier</button>
    </div>        
</div>
</template>

<script>
import {restapi} from '../rest' 
import UploadFile from './UploadFile.vue'

export default {
  name: 'Documentation',
  components : {UploadFile},

  data () {
    return {
      waiting:false,
      uploading:false,
      reponse:null,
      documents:[],
      files:[],
      newfile:false,
    }
  },

  created: function() {
      this.get()
  },
  
    methods:{
        get: function (){
            var api = new restapi();
            var self=this;
            this.waiting=true;
            api.getDocuments().then(response=>{
                self.documents=response;
                this.waiting=false;
            }).catch(()=>{
                this.waiting=false;
            });
        },

        handlefichier: function() {
            for (let i=0;i< this.$refs.addfichier.files.length;i++) {
                this.files.push({"obj":this.$refs.addfichier.files[i],"description":""});
            }
            this.newfile=true;
        },

        /*download: function (id){
            var api = new restapi();
            var self=this;
            this.waiting=true;
            api.getDocument(id).then(response=>{
                var headers = response.headers;
                console.log(headers);
                var blob = new Blob([response.data], {type: "plain/text"})
                //var blob = new Blob([response.data], {type: headers['content-type']})
                var link = document.createElement('a')
                link.href = window.URL.createObjectURL(blob)
                var name="fichier";
                for(let i=0;i<self.documents.length;i++) {
                    if (self.documents[i].id==id) {
                        name=self.documents[i].nom;
                    }
                }
                link.setAttribute('download',name);
                document.body.appendChild(link);
                link.click()
                this.waiting=false;
            }).catch(()=>{
                this.waiting=false;
            });
        },*/

        uploadfichier: function() {
            var api = new restapi();
            var data = new FormData();
            let upload = this.files;

            for( var i = 0; i < upload.length; i++ ){
                let file = upload[i]["obj"];
                data.append('files[' + i + ']', file);
                data.append('description',upload[i]["description"])
            }            
            var self=this;
            this.uploading=true;
            //$("#myModal").modal('show');
            api.postDocUpload(data).then(response=>{
                self.reponse=response;
                self.uploading=false;
                self.newfile=false;
                self.get();
                //$("#myModal").modal('hide');
            }).catch(()=>{self.uploading=false;});

            this.newfile=true;
        },

        annuler : function() {
            this.newfile=false;
            this.files=[];
        }

    }

}
</script>