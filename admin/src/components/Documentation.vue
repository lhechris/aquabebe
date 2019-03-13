<template>
<div class="container">
    <p>Documentation</p>
    <div class="row">
        <div v-if="waiting">On recherche les documents....</div>
        <table style="text-align:left" v-else>
            <tr><th>Nom</th><th colspan="2">Description</th>
            <tr v-for="doc in documents" v-bind:key="'doc'+doc.id">
                <td>{{doc.nom}}</td>
                <td v-if="edit"><input type="text" v-model="doc.description"></td><td v-else>{{doc.description}}</td>
                <!--<td><button class="glyphicon glyphicon-download" v-on:click="download(doc.id)" /></td>-->
                <td v-if="edit"><button class="glyphicon glyphicon-trash" v-on:click="supprimer(doc.id)"></button></td>
                <td v-else><a class="glyphicon glyphicon-download" target="_blank" v-bind:href="'/rest/doc/getfichier/'+doc.id" /></td>
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
            <tr v-for="f in files" v-bind:key="'fic'+f.obj.name">
                <td>{{f.obj.name}}</td>
                <td><input type="text" size="40" v-model="f.description"/></td>
            </tr>
        </table>
        </div>
        <div class="row col-md-7">
            <button type="button" class="btn btn-primary col-md-3" v-on:click="uploadfichier()" >Transferer</button>
            <span class="col-md-3" />
            <button type="button" class="btn btn-primary col-md-3" v-on:click="refresh()" >Annuler</button>
        </div>
    </div>        
    <div class="row mt-3"  style="padding:10px" v-else-if="edit">
        <input  class="col-md-1" type="file" id="files" ref="addfichier" v-on:change="handlefichier()"/>
        <button type="button"  class="btn btn-primary col-md-2" v-on:click="$refs.addfichier.click()">Ajouter un fichier</button>
        <div class="col-md-1" ></div>
        <button type="button" class="btn btn-primary col-md-2" v-on:click="sauver()">Sauver</button>
        <div class="col-md-1" ></div>
        <button type="button" class="btn btn-primary col-md-2" v-on:click="refresh()" >Annuler</button>
    </div>
    <div class="row mt-3" v-else>
        <button type="button" class="btn btn-primary col-md-2" v-on:click="edit=true">Modifier</button>
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
      edit:false,
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
                self.refresh()
                //$("#myModal").modal('hide');
            }).catch(()=>{self.uploading=false;});

            this.newfile=true;
        },

        refresh : function() {
            this.newfile=false;
            this.edit=false;
            this.files=[];
            this.uploading=false;
            this.get();
        },

        supprimer: function(id) {
            for (let i=0;i< this.documents.length;i++) {
                if (this.documents[i].id==id) {
                    this.documents.splice(i,1);
                }
            }
        },
        sauver : function() {
            var api = new restapi();
            var data = new FormData();
            data.append("docs",JSON.stringify(this.documents));
            var self=this;
            this.uploading=true;
            api.postDocUpdate(data).then(()=>{
                self.refresh();
            }).catch(()=>{self.refresh();});
            
        }
    }

}
</script>