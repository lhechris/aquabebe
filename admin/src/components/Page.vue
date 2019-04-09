<template>
<div class="container">
<div>Modification des pages</div>
    <div v-if="waiting==true"> Chargement....</div>
    <div v-else>
        <div class="row mt-3">
            <span class="col-md-5"></span>
            <select v-model="page" v-on:change="refresh()" class="col-md-2" >
                <option v-for="p in pages" v-bind:key="p" v-bind:value="p">{{p}}</option>
            </select>
            <span class="col-md-5"></span>
        </div>
        <div class="mt-3">
            <!--<editor class="form-control" v-model="texte" api-key="n9zk1fj9jf7aqke6igai1s5fpvfvvhwwbdzgedph4wwcbrl7"></editor>-->
            <!--<editor width="950px" height="400px" @upload="showHtml" value="rien">bordel de cul</editor>-->
            <textarea id="basic-example" class="form-control col-md-10" rows="20"  v-model="texte" style="font-size:14px"></textarea>
        </div>
        <div class="row mt-3">
            <span class="col-md-4"></span>
            <button type="button" class="btn btn-primary col-md-2" v-on:click="sauver()">Sauver</button>
            <span class="col-md-2" />
            <button type="button" class="btn btn-primary col-md-2" v-on:click="annuler()">Annuler</button>
        </div>    
    </div>
</div>
</template>

<script>

import {restapi} from '../rest' 
//import Editor from '@tinymce/tinymce-vue';
//import VmEditor from 'vm-editor'
/*import Icon from './Icon'
import { Editor, EditorContent,EditorMenuBar } from 'tiptap'
import {
  Blockquote,
  CodeBlock,
  HardBreak,
  Heading,
  OrderedList,
  BulletList,
  ListItem,
  TodoItem,
  TodoList,
  Bold,
  Code,
  Italic,
  Link,
  Strike,
  Underline,
  History,
} from 'tiptap-extensions'*/

export default {
  name: 'Page',
  //components :{EditorMenuBar,EditorContent,Icon},

  data () {
    return {
      waiting : true,
      texte: "",
      origtexte:"",
      page:"",
      pages:[],
 /*     editor: new Editor({
        extensions: [
          new Blockquote(),
          new CodeBlock(),
          new HardBreak(),
          new Heading({ levels: [1, 2, 3] }),
          new BulletList(),
          new OrderedList(),
          new ListItem(),
          new TodoItem(),
          new TodoList(),
          new Bold(),
          new Code(),
          new Italic(),
          new Link(),
          new Strike(),
          new Underline(),
          new History(),
        ],
        content: `
          <h1>Yay Headlines!</h1>
          <p>All these <strong>cool tags</strong> are working now.</p>
        `,
      }),*/
    }
  },

  created: function() {
      this.get()
  },

  beforeDestroy() {
      this.editor.destroy()
  },
  
   methods:{

        get: function (){
            var api = new restapi();
            var self=this;
            api.getListPages().then(response=>{
                self.pages=response;
                self.page=self.pages[0];
                self.refresh();
            })
        },

        refresh: function() {
            var api = new restapi();
            var self=this;
            self.waiting=true;
            api.getPage(this.page).then(response=>{
                self.texte=response;
                //self.editor.setContent(response);
                self.origtexte=response;
                self.waiting=false;
            })            
        },

        sauver: function() {
            var api = new restapi();
            var data = new FormData();
            data.append("name",this.page);
            data.append("texte",this.texte);
            var self=this;
            api.postPageUpdate(data).then(()=>{
                self.origtexte=self.texte;
            })
        },

        annuler: function() {
            this.texte=this.origtexte;
        },

    }

}
</script>

