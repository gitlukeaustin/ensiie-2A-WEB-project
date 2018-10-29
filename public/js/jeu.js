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
  	categories: [
    	//{ id:1, type: "Mur", attack:0, defence:8, cost:8, chance:0.1},
      //{ id:2, type: "Soldat", attack:5, defence:1, cost:4, chance:0.15}
     ],
     units: [
     //{ id_cat:1, name: "Mur A", atck_bonus:0, def_bonus:0, chance_bonus:0, description:"Un mur"},
     //{ id_cat:1, name: "Mur B", atck_bonus:0, def_bonus:0, chance_bonus:0, description:"Un mur"},
     //{ id_cat:2, name: "Soldat A", atck_bonus:0, def_bonus:0, chance_bonus:0, description:"Un Soldat"},
     //{ id_cat:2, name: "Soldat B", atck_bonus:0, def_bonus:0, chance_bonus:0, description:"Un Soldat"}
     ],
     
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
        this.pingServer(10);
      }
      else{
        this.adv_login = response.data.adv;
        this.connected = true;
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
    logDelay: function(data,i) {
      self = this;
     
      if(!this.advanceLog){
        self.timeoutId = setTimeout(function() {
          self.log += data[i] + "</br>"; 
          if(i < data.length - 1)
            self.logDelay(data,i+1);  
        }, 1100);
      }
      else{
        this.advanceLog = false;
        self.log += data[i] + "</br>"; 
        if(i < data.length - 1)
          self.logDelay(data,i+1); 
      }
      document.getElementById('log').scroll({
        top: document.getElementById("log").scrollHeight,
        behavior: "smooth"
      });
    },
    cancelTimeout: function() {
      console.log(this.advanceLog);
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
          setTimeout(function(){if(tries > 0)self.pingServer(tries-1);},1000);
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
              this.adv = response.data.adv;
              this.logDelay(response.data.log,0);
            }
            else{
              this.log += "En attente des choix de "+this.adv_login+"</br>";
              this.pingResolution(20);
            }
          }
          else{
            this.adv = response.data.adv;
            this.logDelay(response.data.log,0);
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
          
          if(response.data.resolved){
            cards = JSON.parse(response.data.game.cards);
            console.log(cards);
            console.log(cards[this.adv_login]);
            this.adv = cards[this.adv_login];
            this.logDelay(response.data.log,0);
          }
          else{
            setTimeout(function(){if(tries > 0)self.pingResolution(tries-1);},1000);
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