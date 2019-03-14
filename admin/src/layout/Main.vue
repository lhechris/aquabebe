<template>
<div>
  <nav class="navbar navbar-expand-lg navbar-light bg-light container">
    <a class="navbar-brand" href="#"><img class="img-responsive" width="511" height="114" src="../assets/logo_admin.png" /></a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent" v-if="isregister==true">
      <ul class="navbar-nav mr-auto">
        <li class="nav-item active">
          <router-link class="nav-link" to="/">Accueil </router-link>
        </li>
        <li class="nav-item">
          <router-link class="nav-link" to="/adherents">Adhérents</router-link>
        </li>
        <li class="nav-item">
          <router-link class="nav-link" to="/creneaux">Créneaux</router-link>
        </li>
        <li class="nav-item">
          <router-link class="nav-link" to="/reservations">Réservations</router-link>
        </li>
        <li class="nav-item">
          <router-link class="nav-link" to="/mailing">Mailing</router-link>
        </li>
        <li class="nav-item">
          <router-link class="nav-link" to="/documentation">Documentation</router-link>
        </li>
        <li class="nav-item">
          <router-link class="nav-link" to="/pages">Pages</router-link>
        </li>
        <li class="nav-item">
          <router-link class="nav-link" to="/parametres">Parametres</router-link>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#" v-on:click="logout">logout</a>
        </li>
      </ul>
    </div>
  </nav>
  <div v-if="isregister==false">
      <div class="loginmodal-container">
        <h1>Login to Your Account</h1><br>
        <h2 v-if="badlogin!=''" color="red">{{badlogin}}</h2><br>
        <div class="form-group">
          <input type="text"     class="form-control" v-model="user" placeholder="Username">
          <input type="password" class="form-control" v-model="pass" placeholder="Password">
          <input type="submit"   name="login" class="form-control login loginmodal-submit" value="Login" v-on:click="login()">
        </div>
        <div class="login-help">
          <a href="#">Register</a> - <a href="#">Forgot Password</a>
        </div>
      </div>
  </div>
</div>
</template>

<script>
import {restapi} from '../rest' 

export default {
  name: 'Main',

  data()  {
    return {
      isregister:true,
      user:"",
      pass:"",
      badlogin:""
    }
  },
  created : function (){
    this.get()
  },
  methods: {
      get: function (){
        var api = new restapi();
        var self=this;
        api.isRegister().then(response=>{
          self.isregister=response=="oui";
        });
      },  
      login: function (){
        var api = new restapi();
        var self = this;

        var data = new FormData();
        data.append("login",self.user);
        data.append("pass",self.pass);
        api.postLogin(data).then(response=>{
          if (self.response=="oui") {
            self.isregister=true;
            self.badlogin="";
          } else {
            self.badlogin=response;
          }
          self.get();
          
        });
      },
      logout: function() {
        var api = new restapi();
        var self = this;
        api.postLogout().then(()=>{
          self.isregister=false;
          self.get();
        });
      } 
  }

}
</script>
<style scoped>
h1, h2 {
  font-weight: normal;
}
ul {
  list-style-type: none;
  padding: 0;
}
li {
  display: inline-block;
  margin: 0 10px;
}
a {
  color: #42b983;
}

.container{
  text-align:left;
}

.loginmodal-container {
  padding: 30px;
  max-width: 350px;
  width: 100% !important;
  background-color: #F7F7F7;
  margin: 0 auto;
  border-radius: 2px;
  box-shadow: 0px 2px 2px rgba(0, 0, 0, 0.3);
  overflow: hidden;
  font-family: roboto;
}

.loginmodal-container h1 {
  text-align: center;
  font-size: 1.8em;
  font-family: roboto;
}

.loginmodal-container input[type=submit] {
  width: 100%;
  display: block;
  margin-bottom: 10px;
  position: relative;
}

.loginmodal-container input[type=text], input[type=password] {
  height: 44px;
  font-size: 16px;
  width: 100%;
  margin-bottom: 10px;
  -webkit-appearance: none;
  background: #fff;
  border: 1px solid #d9d9d9;
  border-top: 1px solid #c0c0c0;
  /* border-radius: 2px; */
  padding: 0 8px;
  box-sizing: border-box;
  -moz-box-sizing: border-box;
}

.loginmodal-container input[type=text]:hover, input[type=password]:hover {
  border: 1px solid #b9b9b9;
  border-top: 1px solid #a0a0a0;
  -moz-box-shadow: inset 0 1px 2px rgba(0,0,0,0.1);
  -webkit-box-shadow: inset 0 1px 2px rgba(0,0,0,0.1);
  box-shadow: inset 0 1px 2px rgba(0,0,0,0.1);
}

.loginmodal {
  text-align: center;
  font-size: 14px;
  font-family: 'Arial', sans-serif;
  font-weight: 700;
  height: 36px;
  padding: 10px 8px;
/* border-radius: 3px; */
/* -webkit-user-select: none;
  user-select: none; */
}

.loginmodal-submit {
  /* border: 1px solid #3079ed; */
  border: 0px;
  color: #fff;
  text-shadow: 0 1px rgba(0,0,0,0.1); 
  background-color: #4d90fe;
  padding: 17px 0px;
  font-family: roboto;
  font-size: 14px;
  /* background-image: -webkit-gradient(linear, 0 0, 0 100%,   from(#4d90fe), to(#4787ed)); */
}

.loginmodal-submit:hover {
  /* border: 1px solid #2f5bb7; */
  border: 0px;
  text-shadow: 0 1px rgba(0,0,0,0.3);
  background-color: #357ae8;
  /* background-image: -webkit-gradient(linear, 0 0, 0 100%,   from(#4d90fe), to(#357ae8)); */
}

.loginmodal-container a {
  text-decoration: none;
  color: #666;
  font-weight: 400;
  text-align: center;
  display: inline-block;
  opacity: 0.6;
  transition: opacity ease 0.5s;
} 

.login-help{
  font-size: 12px;
}


</style>