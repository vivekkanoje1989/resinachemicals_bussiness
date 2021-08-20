<script>
    var cities = [];
    var states = [];
    function getCities(){
        $.getJSON(base_url+'public/cities.json', function(data){ 
            cities = data.cities;
        });
    }  

    function getStates(){
        $.getJSON(base_url+'public/states.json', function(data){ 
            states = data.states;
        })
    }     

    var dropdownCities = [];
    var dropdownStates = [];		

    function makeCityDropdown(state_id){
        dropdownCities = jQuery.grep(cities, function( n, i ) {
            return ( n.state_id == state_id);
        })
    }

    function makeStateDropdown(id){
        dropdownStates = jQuery.grep(states, function( n, i ) {
            return ( n.id == id);
        })
    }
</script>