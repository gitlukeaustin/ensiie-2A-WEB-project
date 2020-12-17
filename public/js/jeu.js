window.onload = function () {
var app =new Vue({
  el: "#app",
  data: {
    info : 0,
    img: {
      castle:"http://simpleicon.com/wp-content/uploads/castle.png",
      ecole1:"image/ecole1.png",
      ecole2:"image/ecole2.png"
   },
  	categories: [],
    units: [],
    log: "en attente de joueurs...</br>",
    coins:50,
    selected: [],
    adv: [],
    locked:false,
    game:{},
    connected:false,
    adv_login:'',
    timeoutId: 0,
    advanceLog:false
  },
  mounted: function(){
    axios
    .get('http://localhost:8080/jeu.php?action=fetch_categories')
    .then(response => {
      // JSON responses are automatically parsed.
      this.categories = response.data;
      console.log(this.categories);
    })
    .catch(error => console.log(error));
    axios
    .get('http://localhost:8080/jeu.php?action=fetch_units')
    .then(response => {
      // JSON responses are automatically parsed.
      this.units = response.data;
      console.log(this.units);

    })
    .catch(error => console.log(error));
    // Create WebSocket connection.
    axios
    .get('http://localhost:8080/jeu.php?action=connect')
    .then(response => {
      // JSON responses are automatically parsed.
      this.game = response.data.game;
      console.log(response);

      if(!response.data.connected){
        this.pingServer(20);
      }
      else{
        this.adv_login = response.data.adv;
        this.connected = true;
        this.log += "Joueur trouvé.</br>";
      }
     
    })
    .catch(error => console.log(error)); 
   },
   filters: {
    // Filter definitions
     lowercase(value) {
         return value.toLowerCase();
     },
     trim(value) {
       return value.toString().substring(1);
     }
  },
  methods: {
    showHit(login,index,number){
      if(login == this.adv_login){
        icon = document.getElementById('adv_cards').childNodes[index];
      }
      else{
        icon = document.getElementById('placed_cards').childNodes[index];
      }
      hit = icon.childNodes[0];
      hit.innerHTML = number;
      left = icon.offsetLeft;
      hit.classList.remove('faded');
      hit.classList.add('fadeIn');
      hit.classList.add('floatdown');
      setTimeout(function(){
        hit.classList.remove('fadeIn');
        hit.classList.add('fadeSlow');},600);

    },
    showAttack(login,index,login_def,index_def){
      if(login == this.adv_login){
        icon = document.getElementById('adv_cards').childNodes[index];
        icon_adv = document.getElementById('placed_cards').childNodes[index_def];
        tp = +28;
      }
      else{
        icon = document.getElementById('placed_cards').childNodes[index];
        icon_adv = document.getElementById('adv_cards').childNodes[index_def];
        tp = -28;
      }
      attack = icon.childNodes[2];
      left = icon_adv.offsetLeft - icon.offsetLeft;
      attack.classList.remove('faded');
      attack.classList.add('fadeIn');
      attack.setAttribute("style", "transition: transform 0.46s; transform: translate("+left+"px,"+tp+"px)");
      setTimeout(function(){
        attack.classList.remove('fadeIn');
        attack.classList.add('fade');
        setTimeout(function(){        
          attack.removeAttribute("style");
        },640);
      },560);
    },
    applyClass: function(animation){
      if(animation !== undefined && animation.length > 0){
        if(animation.length == 4){
          this.showHit(animation[0],animation[1],animation[3]);
        }
        else if(animation.length == 5){
          this.showAttack(animation[0],animation[1],animation[3],animation[4]);
        }
        else if(animation[0] == this.adv_login){
          document.getElementById('adv_cards').childNodes[animation[1]].classList.add(animation[2]+'down');
        }
        else{
          document.getElementById('placed_cards').childNodes[animation[1]].classList.add(animation[2]);
        }
      }
    },
    showWinner: function(winner){
      if(winner == this.adv_login){
        castle = document.getElementById('chateau_adversaire');
      }
      else{
        castle = document.getElementById('chateau_joueur');
      }
      image = castle.childNodes[0];
      console.log(image);
      image.classList.remove('faded');
      image.classList.add('fadeIn');
      image.setAttribute("style", "transition: transform 0.46s; transform: translateY(-30px)");
    },
    logDelay: function(data,i) {
      self = this;
      self.timeoutId = setTimeout(function() {
        if(data.log[i].length > 0)
          self.log += data.log[i] + "</br>"; 
        if(i < data.log.length - 1){
          self.applyClass(data.animations[i]);
          self.logDelay(data,i+1);  
        }
        else if(data.winner != null){
          self.showWinner(data.winner);
        }
      }, 1100);
      
      document.getElementById('log').scroll({
        top: document.getElementById("log").scrollHeight,
        behavior: "smooth"
      });
    },
    cancelTimeout: function() {
      this.advanceLog = true;
    },
    pingServer(tries){
      const formData = new FormData();
   
      formData.append('data', JSON.stringify(this.game));
      axios
      .post('http://localhost:8080/jeu.php?action=ping_server',formData)
      .then(response => {
        // JSON responses are automatically parsed.
        console.log(response.data);
        //this.adv = response.data.adv;
        self = this;
        if(!response.data.connected){
          setTimeout(function(){
            if(tries > 0 && !self.locked){
              self.pingServer(tries-1);
            }else if(!self.locked){
                self.log += "Aucun joueur trouvé. Veuillez rafraîchir la page" + "</br>";
            }
            
          },1000);
        }
        else{
          this.log += "Joueur trouvé.</br>";
          this.adv_login = response.data.adv;
          this.connected = true;
        }
      })
      .catch(error => console.log(error));
    },
  	send: function() {
      if(this.locked){
        this.log += "Déjà envoyé. </br>";
      }
      else{
        this.locked = true;
        console.log("sending");
        const formData = new FormData();
        if(this.connected){
          action = 'send_selection';
        }else{
          action = 'simulate';
        }

        formData.append('data', JSON.stringify({'selected':this.selected,'game':this.game,'adv':this.adv_login}));
        axios
        .post('http://localhost:8080/jeu.php?action='+action,formData)
        .then(response => {
          // JSON responses are automatically parsed.
          console.log(response.data);
          
          if(this.connected){
            if(response.data.resolved){
              this.adv = response.data.adv_cards
              this.logDelay(response.data,0);
            }
            else{
              this.log += "En attente des choix de "+this.adv_login+"</br>";
              this.pingResolution(20);
            }
          }
          else{
            this.adv_login = response.data.adv;
            this.adv = response.data.adv_cards;
            this.logDelay(response.data,0);
          }
          
        })
        .catch(error => console.log(error));
      }
    },
    pingResolution: function(tries){
      const formData = new FormData();

      formData.append('data', JSON.stringify({'game':this.game}));
        axios
        .post('http://localhost:8080/jeu.php?action=ping_resolution',formData)
        .then(response => {
          // JSON responses are automatically parsed.
          console.log(response.data);
          self = this;
          if(response.data.resolved){
            cards = JSON.parse(response.data.game.cards);
            console.log(cards);
            console.log(cards[this.adv_login]);
            this.adv = cards[this.adv_login];
            this.logDelay(response.data,0);
          }
          else{
            setTimeout(function(){
              if(tries > 0){
                self.pingResolution(tries-1);
              } else {
                self.log += "Resolution timeout.";
              }
            },1000);
          }
          
        })
        .catch(error => console.log(error));
    },
    selectCard: function(card){

      var selected_units = this.units.filter(x => x.id_cat == card.id);
  
      var random_unit = selected_units[Math.floor(Math.random() * selected_units.length)];
      //console.log(random_unit);
      if(this.coins >= card.cost){
      	this.selected.push(Object.assign(random_unit,card));
        console.log(this.selected);
      	this.coins -= card.cost;
      }
      else{
      	this.log += "Pas assez d'argent!</br>";
      }
    }
  }
})
}