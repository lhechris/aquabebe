<template>
<div class="container" >
<div v-if="islock==false">
<p class="row">
  <form>
    <transition name="slide"  mode="out-in">
    <div v-if="etape==-1" key="etapeq">
      <inscription-intro v-on:suivant="suivantclick"/>
    </div>    
    <div v-if="etape==0" key="etape0">
      <inscription-e0 v-on:suivant="suivantclick" v-bind:saison="saison" />
    </div>    
    <div v-if="etape==1" key="etape1">      
      <inscription-e1 v-bind="{nomenfant:nomenfant,
                               prenomenfant:prenomenfant,
                               naissance:naissance,
                               sexe:sexe,
                               email:email,
                               adresse:adresse,
                               codepostal:codepostal,
                               ville:ville,
                               handicap:handicap
                               }"
                      v-on:nomenfant="nomenfant=$event"
                      v-on:prenomenfant="prenomenfant=$event"
                      v-on:naissance="naissance=$event"
                      v-on:sexe="sexe=$event"
                      v-on:email="email=$event"
                      v-on:adresse="adresse=$event"
                      v-on:codepostal="codepostal=$event"
                      v-on:ville="ville=$event"
                      v-on:handicap="handicap=$event"/>
    </div>
    <div v-if="etape==2" key="etape2">
      <h2>etape 2 : Parents </h2>
      <div class="form-group forminscription ">
        <label for="nomparent1" >Nom du parent 1</label>
        <span class="obligatoire" v-if="nomparent1==''">Champ obligatoire</span>
        <div><input type="text" class="form-control" name="nomparent1" v-model="nomparent1" /></div>
      </div><div class="form-group forminscription">
        <label for="prenomparent1" >Prénom parent 1</label>
        <span class="obligatoire" v-if="prenomparent1==''">Champ obligatoire</span>
        <div><input type="text"  class="form-control" name="prenomparent1" v-model="prenomparent1" /></div>
      </div><div class="form-group forminscription">
          <label for="sexeparent1" >Sexe</label>
          <div><input type="radio" name="sexeparent1" value="1" v-model="sexeparent1"/>&nbsp;M&nbsp;<input type="radio" name="sexeparent1" value="0" v-model="sexeparent1"/>&nbsp;F</div>
      </div><div class="form-group forminscription">
        <label for="telparent1" >Téléphone 1</label>
        <span class="obligatoire" v-if="telparent1==''">Champ obligatoire</span>
        <div ><input type="text"  class="form-control" name="telparent1" v-model="telparent1"/></div>
      </div><div class="form-group forminscription">
        <label for="nomparent2" >Nom du parent 2</label>
        <div><input type="text"  class="form-control" name="nomparent2" v-model="nomparent2"/></div>
      </div><div class="form-group forminscription">
        <label for="prenomparent2" >Prénom parent 2</label>
        <div><input type="text"  class="form-control" name="prenomparent2" v-model="prenomparent2" /></div>
      </div><div class="form-group forminscription">
          <label for="sexeparent2" >Sexe</label>
          <div><input type="radio" name="sexeparent2" value="1" v-model="sexeparent2"/>&nbsp;M&nbsp;<input type="radio" name="sexeparent2" value="0" v-model="sexeparent2"/>&nbsp;F</div>
      </div><div class="form-group forminscription">
        <label for="telparent2" >Téléphone 2</label>
        <div><input type="text"  class="form-control" name="telparent2" v-model="telparent2"/></div>
      </div>
    </div>
    <div v-if="etape==3" key="etape3">
      <h2>etape 3:  Choix des créneaux </h2>  
      <p>Voici les créneaux auxquels vous pouvez inscrire votre enfant. Indiquez votre créneau préféré (1) puis, à défaut, les autres créneaux (2,3...).</p>
      <p>Si aucune autre demande n'a été validée avant que vous n'ayez terminé votre inscription et si votre créneau préféré a des places libres, alors une place sur ce créneau vous est réservée pendant 7 jours.</p>
      <p>Vous avez donc 7 jours au maximum pour nous faire parvenir votre règlement et confirmer votre inscription.</p>
      <p>Si votre créneau préféré comporte uniquement des places en attente de validation de paiement (en jaune), nous attendrons la fin du délai de 7 jours (attente max du paiement par autrui). Si au terme de ce délai, le règlement de l'autre personne ne nous est pas parvenu, vous remonterez dans la liste d'attente et la place pourra éventuellement vous être attribuée. En attendant, une place sur votre 2ème, 3ème... choix est réservée. </p>
      <p class="obligatoire" v-if="creneauok==false">Vous devez choisir au moins un creneau (1 dans une des case)</p>
      <div class="row forminscription" v-for="creneau of creneaux" v-bind:key="'creneau'+creneau.id">
        <div class="col-md-4"><input type="number" size="1" v-bind:name="creneau.inputname" v-model="creneau.inputval" /></div>
        <div class="col-md-4">{{creneau.name}} - {{creneau.lieu}}</div>
        <div class="col-md-4">({{creneau.inscrits}} inscrits sur {{creneau.capacite}})</div>
      </div>
      <div class="row forminscription">
        <div class="col-md-8">Pour valider l'inscription, le paiement intégral doit être parvenu à l'association dans les 7 jours suivant la validation de ce formulaire. Vous pouvez payer en deux ou plusieurs chèques.</div>
        <div class="cold-md-4"><span>Lu et accepté :&nbsp;*&nbsp;</span><span><input name="lu1" value="true" type="checkbox" /></span></div>
      </div>
      <div class="row forminscription">
        <div class="col-md-8">L'adhésion annuelle à l'association (20€) est à régler spécifiquement et uniquement pour le 1er enfant. La cotisation, elle, est calculée en fonction de la date d'inscription et du nombre d'enfants inscrits. Le montant à payer est indiqué dans la page Tarifs.</div>
        <div class="col-md-4">Lu : &nbsp;<input name="lu2" value="true" type="checkbox" /></div>
      </div>
      <div class="row forminscription">
          <div class="col-md-8">L'accès à la piscine n'est possible qu'après présentation du carnet de vaccination
                                    à jour, remise du règlement intérieur signé et remise d'un certificat 
                                    médical de moins de 3 mois attestant qu'il n'y a pas de contre-indication à la pratique de l'activité 
                                    pour l'enfant.</div>
          <div class="cold-md-4"><span>Lu et accepté :&nbsp;*&nbsp;</span><span><input name="lu3" value="true" type="checkbox" /></span></div>
      </div>
    </div>
    <div v-if="etape==4" key="etape4">
      <h2>etape 4:  Autorisations</h2> 
      <div class="row">&nbsp;* Ces informations sont indispensables pour traiter votre demande.</div>
      <h2 class="row">Demande d'autorisation de diffusion d'image</h2>
      <div class="row">
        <div class="col-md-4">Je déclare avoir eu connaissance que toute personne présente lors de l'activité de 
                                                      l'association Aqua-Bébé ci-dessus identifiée à laquelle nous adhérons puisse être 
                                                      photographiée. &nbsp;*</div>
        <div class="col-md-8">
          <p class="obligatoire" v-if="imagediffusion==0">Vous devez choisir parmi les 2 choix</p>
          <div class="row forminscription">
            <div class="col-md-1"><input name="image_diffusion" value="1" type="radio" v-model="imagediffusion"></div>
            <div class="col-md-11">Je reconnais et accepte que les images puissent être utilisées pour support pouvant assurer 
                                  la promotion de l'association Aqua-bébé et plus particulièrement sur les plaquettes et le site 
                                  web de l'association (http://www.aquabebe.fr)</div>
          </div>
          <div class="row forminscription">
            <div class="col-md-1"><input name="image_diffusion" value="2" type="radio"  v-model="imagediffusion"></div>
            <div class="col-md-11">Je refuse que les images puissent être utilisées pour support pouvant assurer la promotion 
                                  de l'association Aqua-Bébé et le cas échéant, elles seront rendues floues afin que l'identification 
                                  soit impossible.</div>
          </div>
        </div>
      </div>
    </div>
    <div v-if="etape==5" key="etape5">
      <h2>etape 5:  Réglement Intérieur</h2>
      <div class="row">
        <div class="col-md-12">&nbsp;*Ces informations sont indispensables pour traiter votre demande.</div>
      </div><div>
          <h2>Règlement intérieur</h2><h2>Aqua-Bébé</h2><h2>Saison 2017-2018</h2>
          <h3>Adhésion - Cotisation</h3>
          <p>L'adhésion à l'association est obligatoire. La somme de 20€ non remboursable aprés validation de la séance d'essai, doit être acquittée par famille pour accéder 
									aux activités de l'Association.<br>La cotisation, dont le montant est voté en assemblée générale, permet à l'enfant et à son accompagnateur 
									déclaré d'accéder aux activités. Celle-ci est valable du 13 septembre 2017 au 23 juin 2018 et sera recalculée 
									au nombre de mois d'activité restants pour les inscriptions en cours d'année.<br>Une réduction est accordée aux fratries.</p><br><h3>Activité</h3><p>L'activité des bébés nageurs est encadrée par un maitre-nageur diplômé. Elle est dispensée à la piscine du <u>Centre René Bouscairol</u> à Villeneuve Tolosane et <u>au Centre Rosine BET</u> à Saint Lys.<br><br><b>La remise d'un certificat médical de moins de 3&nbsp;mois attestant qu'il n'y a pas de contre-indication 
										à la pratique de la baignade pour l'enfant ainsi que le justificatif précisant que l'enfant est 
										à jour de ses vaccins <u>sont obligatoires dès le premier bain.</u></b><br><br>L'enfant et son accompagnateur déclaré s'engagent à respecter le Règlement Intérieur 
                                 de la piscine du centre dont notamment :<br>- le port par l'enfant d'une couche (s'il n'est pas totalement propre) ou d'un maillot étanche spécial piscine; <br>- le port d'un maillot de bain par l'accompagnant (éviter le short de bain pour les Messieurs);<br>- le passage sous la douche avant la baignade;<br>- n'abandonner ni couches, ni cotons, ni lingettes ou tout autre chose usagée dans les 
                                  locaux mais utiliser les poubelles mises à disposition;<br>- se déchausser avant l'accès aux vestiaires.<br><br>L'enfant et son accompagnateur déclaré <u>s'engagent à prendre part</u> à la vie de l'association (participation à l'accueil, passage de la raclette, rangement des cabines, 
									rangement des jeux à disposition des enfants...).</p><br><h3>Horaires</h3><p>Le jour et l'horaire de l'activité sont attribués pour l'année lors de l'inscription. L'enfant et son accompagnateur 
                                  s'engagent à respecter le créneau attitré. Un planning des séances sur la saison est établi et affiché. L'association s'engage sur 30 séances par créneau pour une année complète.<br><br>L'enfant et son accompagnateur déclaré  <u>s'engagent à prévenir</u> le maître-nageur sauveteur (MNS) de leur absence via l'e-mail spécifique  à son maitre-nageur fourni en bas du planning.</p><h3>Communication</h3><p>L'association Aqua bébé communique par mail sauf en cas d'urgence par SMS. Elle décline toute responsabilité en cas de non réception des messages.</p><h3>Arrêt d'activité</h3><p>Un remboursement de la cotisation pourra être considéré en cas d'arrêt d'activité 
                                sur présentation d'un justificatif (problème de santé de l'enfant, changement de situation 
                                familiale, mutation...). Les demandes seront étudiées par le Conseil d'Administration qui 
                                s'engage à les traiter confidentiellement.</p>
      </div><div class="row forminscription">
          <div class="col-md-6">J'ai lu et j'accepte d'appliquer le règlement intérieur.&nbsp;*</div>
          <div class="col-md-2"><input name="reglement" value="false" type="checkbox" v-model="reglement"/></div>
      </div>
    </div>
    <div v-if="etape==6" key="etape6">
      <h2>etape 6:  Paiement</h2>
      <p>* Ces informations sont indispensables pour traiter votre demande.</p>
      <p>Choisissez votre moyen de paiement puis validez ce formulaire.
         A la validation, votre inscription sera en attente de paiement. Vous serez informés par mél
         de la réception de votre paiement, puis de l'attribution de votre créneau.</p>
      <div class="row">
        <div class="col-md-2">Choix du paiement :&nbsp;*</div>
        <div class="col-md-10">
            <input name="paiement_moyen" value="1" type="radio" v-model="paiement"/>
            <span><strong>Je choisis de payer par chèque.</strong><br>
										Après avoir validé ce formulaire, le paiement intégral (participation + adhésion) devra parvenir 
										à l'association dans les 7 jours pour confirmer l'inscription de lulu. 
										<br><br>
										Le montant annuel du paiement  
                                        (cotisation + adhésion) est 200€(180€ + 20€) pour un enfant et 360€ (340€ + 20€) pour 2 enfants.
                                        <p class="avertissement">Le montant de l'adhésion de 20€ est à acquitter via un chèque à part.</p>
										<br><br>
										Si vous faites une inscription en cours d'année, 
										merci de consulter la page Tarifs pour connaître le montant de l'inscription. 
										<br>Si besoin, vous pouvez contacter AquaBébé (<a href="mailto:contact@aquabebe.fr">contact@aquabebe.fr</a>) pour confirmer le montant de votre cotisation. <br><br>
										Les chèques sont à établir à l'ordre de AQUA-BEBE et à envoyer à 
										<address>AQUA-BEBE<br>chez Florence Michel-Jerolon<br>1 rue Berlioz<br>31880 La Salvetat-Saint-Gilles</address><br><strong>Important : </strong>
										Un des chèques doit être de 20€, montant correspondant à l'adhésion annuelle à l'association.   
										Le détail des chèques à envoyer se trouve sur la page Tarifs.
										<br><br>
            </span>
        </div>
      </div>
    </div>
    </transition>
    <div v-if="etape==7">
      <h2>Confirmation</h2>
      <p>Votre demande a été prise en compte vous recevrez d'ici quelques minute un email de confirmation.</p>    
    </div>

  </form>
  </p>
  <button v-if="etape>1 && etape<7" class="btn-info" v-on:click="precedentclick">Précédent</button>
  <button v-if="etape>0 && etape<6" class="btn-info" v-on:click="suivantclick">Suivant</button>
  <button v-if="etape==6" class="btn-info" v-on:click="validerclick">Valider</button>
</div>
<div v-else>
  <p>Désolé les inscriptions ne sont pas ouvertes !</p>
  <div class="row form-group">
    <input type="password" class="form-control col-md-2" v-model="inscriptionpass" placeholder="Code de déblocage" />
    <input type="submit"  name="login" class="form-control login loginmodal-submit col-md-2" value="Login" v-on:click="login()">
    <div class="col-md-8"></div>
  </div>
</div>
</div>

</template>

<script>
import {restapi} from '../rest';
import MainLayout from '../layout/Main.vue'
import moment from 'moment';
import 'moment/locale/fr';

import InscriptionIntro from './InscriptionIntro.vue';
import InscriptionE0 from './InscriptionE0.vue';
import InscriptionE1 from './InscriptionE1.vue';

export default {
  name: 'Inscription',
  components: {
      MainLayout,
      InscriptionIntro,
      InscriptionE0,
      InscriptionE1
  },
  data () {
    return {
      etape:-1,
      saison:"",
      creneaux:{},
      nomenfant:"coucou",
      prenomenfant:"truc",
      adresse:"",
      codepostal:"",
      ville:"",
      email:"",
      sexe:-1,
      naissance:"",
      handicap:-1,
      nomparent1:"",
      prenomparent1:"",
      sexeparent1:-1,
      telparent1:"",
      nomparent2:"",
      prenomparent2:"",
      sexeparent2:-1,
      telparent2:"",      
      date:this.getNow(),
      creneauok:false,
      imagediffusion:0,
      reglement:false,
      paiement:-1,
      islock:false,
      inscriptionpass:""
    }
  },
  created: function() {
      moment.locale('fr');
      var api = new restapi();
      var self=this;
      api.getSaison().then(response=>{
        self.saison=response;
      });
      api.getIsInscriptionLocked().then(response=>{
        self.islock=response;
      });
  },
   methods:{
      suivantclick: function(event) {
        if (this.etape<6) {
          if (! this.check()) { return;}
                    
          this.etape+=1;
          if (this.etape==3) {
            var api = new restapi();
            var self=this;
            api.getCreneauxForNaissance(this.naissance).then(response=>{
              self.creneaux=response;
              var i;
              for (i in self.creneaux) {
                self.creneaux[i]["inputname"]="creneau_"+self.creneaux[i]["id"];
                self.creneaux[i]["inputval"]="";
                if (i==0) {self.creneaux[i]["inputval"]=1;} 
              }
            })
          }
        }
      },
      precedentclick: function(event) {
        if (this.etape>1) {
            if (this.check()) {
              this.etape-=1;
            }
        }
      },
      validerclick: function(event) {
        if (this.etape==6) {
            if (this.check()) {
              this.etape=7;
              var api = new restapi();
              var self=this;
              var inscription=new FormData();
              inscription.append("nomenfant", this.nomenfant);
              inscription.append("prenomenfant",this.prenomenfant);
              inscription.append("adresse",this.adresse);
              inscription.append("codepostal",this.codepostal);
              inscription.append("ville",this.ville);
              inscription.append("email",this.email);
              inscription.append("sexe",this.sexe);
              inscription.append("naissance",this.naissance);
              inscription.append("handicap",this.handicap);
              inscription.append("nomparent1",this.nomparent1);
              inscription.append("prenomparent1",this.prenomparent1);
              inscription.append("sexeparent1",this.sexeparent1);
              inscription.append("telparent1",this.telparent1);
              inscription.append("nomparent2",this.nomparent2);
              inscription.append("prenomparent2",this.prenomparent2);
              inscription.append("sexeparent2",this.sexeparent2);
              inscription.append("telparent2",this.telparent2);
              inscription.append("imagediffusion",this.imagediffusion);
              inscription.append("reglement",this.reglement);
              inscription.append("paiement",this.paiement);
              for (var i in this.creneaux) {
                inscription.append(this.creneaux[i]["inputname"],this.creneaux[i]["inputval"]);
              }

              api.postInscription(inscription).then(response=>{
                  console.log(response);
              })
            }
        }
      },

      check: function() {
        if (this.etape<1) { return true;}

        if (this.etape==1) {
          if ((this.nomenfant=="") || (this.prenomenfant=="") || (this.naissance=="") || (this.sexe==-1) || (this.email=="")){ return false;}

        } else if (this.etape==2) {
          if ((this.nomparent1=="") || (this.prenomparent1=="") || (this.telparent1=="") ){ return false;}

        } else if (this.etape==3) {
            this.creneauok=false;
            for (var i in this.creneaux) {
                if (this.creneaux[i]["inputval"]=="1") {this.creneauok=true;}
            }
            return this.creneauok;

        } else if (this.etape==4) {
           if (this.imagediffusion==0) {return false; }

        } else if (this.etape==5) {
           if (this.reglement==false) {return false; }

        } else if (this.etape==6) {
           console.log(this.paiement);
           if (this.paiement==-1) {return false; }

        }

        return true;
      },

      getNow: function() {
        moment.locale('fr');
        return moment().format('DD MMMM YYYY');
      },

      login:function() {
        var api = new restapi();
        var self=this;
        var pass=new FormData();
        pass.append("pass", this.inscriptionpass);
        api.unlockInscription(pass).then(response=>{            
            if (response=="success") {
              self.islock=false;
            }
        })
      }

    }

}
</script>

<style scoped>
.forminscription {
  background : linear-gradient( to right,rgba(113,183,244,0.8), rgba(255,128,128,0.3));
  border-radius : 10px;
  margin:5px;
  padding : 5px;

}

.border {
    border-color: #182a84;
    border-style: solid;
    border-width: 1px;
    margin-top: 30px;
    background-color: white;
}

.slide-enter-active {
  transition: 1s;
}
.slide-leave-active {
  transition: 1s;  
}

.slide-enter {
  transform: translate(0, -100%);
  opacity:0;
}
.slide-leave-to {
  transform: translate(0, 100%);
  opacity:0;
}

</style>