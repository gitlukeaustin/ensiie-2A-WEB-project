window.onload = function () {
var app =new Vue({
  el: "#app",
  data: {
    info : 0,
    img: {
      castle:"http://simpleicon.com/wp-content/uploads/castle.png"
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
    locked:false
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
  	send: function() {
      if(this.locked){
        this.log += "Déjà envoyé. </br>";
      }
      else{
        this.locked = true;
        console.log("sending");
        const formData = new FormData();
   
        formData.append('data', JSON.stringify(this.selected));
        axios
        .post('http://localhost:8080/jeu.php?action=send_selection',formData)
        .then(response => {
          // JSON responses are automatically parsed.
          console.log(response.data);
          this.adv = response.data.adv;

          for(i = 0; i < response.data.log.length;i++){
             this.log += response.data.log[i] + "</br>";
          }
        })
        .catch(error => console.log(error));
      }
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