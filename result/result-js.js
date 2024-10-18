const leaderboard_button=document.getElementById("leaderboard_button");
const leaderboard_div=document.getElementById("leaderboard_div");
const detailed_button=document.getElementById("detailed_button");
const detailed_div=document.getElementById("detailed_div");

leaderboard_button.addEventListener("click",visibilityL);
detailed_button.addEventListener("click",visibilityD);

//Function to change the display of the div send as parameter
function visibilityL(){
    if(leaderboard_div.hidden==false){
        leaderboard_div.hidden=true;
        this.innerHTML="Show Leaderboard Ranking";
    }else{
        leaderboard_div.hidden=false;
        this.innerHTML="Hide Leaderboard Ranking";
    }
}

function visibilityD(){
    if(detailed_div.hidden==false){
        detailed_div.hidden=true;
        this.innerHTML="Show Detailed Result";
    }else{
        detailed_div.hidden=false;
        this.innerHTML="Hide Detailed Result";
    }
}