<style>
  input[type="file"]{
    position: absolute;
    top: -500px;
  }

</style>

<template>
  <div class="container">
    <div class="row">
        <label class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <input type="file" id="files" ref="files" multiple v-on:change="handleFilesUpload()"/>
        </label>
    </div>
    <div class="row">
        <div v-for="(file, key) in value" class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <div class="row">
        <span class="col-xs-3 col-sm-3 col-md-3 col-lg-3">{{ file.name }}</span>
        <button class="col-xs-1 col-sm-1 col-md-1 col-lg-1 glyphicon glyphicon-trash btn" v-on:click="removeFile( key )"></button>
        </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <button v-on:click="addFiles()" class="btn ">Joindre un fichier</button>
        </div>
    </div>
  </div>
</template>

<script>
  export default {
    name : "UploadFile",
    /*
      Defines the data used by the component
    */
    data(){
      return {
        value: []
      }
    },

    /*
      Defines the method used by the component
    */
    methods: {
      /*
        Adds a file
      */
      addFiles(){
        this.$refs.files.click();
      },

      // Submits files to the server
     /* submitFiles(){
        //Initialize the form data
        let formData = new FormData();

        //Iteate over any file sent over appending the files
        //to the form data.        
        for( var i = 0; i < this.value.length; i++ ){
          let file = this.value[i];

          formData.append('files[' + i + ']', file);
        }

        //Make the request to the POST /select-files URL
        axios.post( '/select-files',
          formData,
          {
            headers: {
                'Content-Type': 'multipart/form-data'
            }
          }
        ).then(function(){
          console.log('SUCCESS!!');
        })
        .catch(function(){
          console.log('FAILURE!!');
        });
      },*/

      /*
        Handles the uploading of files
      */
      handleFilesUpload(){
        let uploadedFiles = this.$refs.files.files;

        /*
          Adds the uploaded file to the files array
        */
        for( var i = 0; i < uploadedFiles.length; i++ ){
          this.value.push( uploadedFiles[i] );
        }
        this.$emit('input',this.value);        

      },

      /*
        Removes a select file the user has uploaded
      */
      removeFile( key ){
        this.value.splice( key, 1 );
      }
    }
  }
</script>