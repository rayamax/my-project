const indexResults = document.getElementById('index-results');
const urlResults = "https://www.thesportsdb.com/api/v1/json/1/eventsnextleague.php?id=4334";
fetch(urlResults)
    .then((resp)=>resp.json())
    .then(function(data) {
        let teams = data.events;
        let stand = 0;
        return teams.map(function(team){
            let tr = createNode('tr'),
                th1 = createNode('th'),
                th2 = createNode('th'),
                th3 = createNode('th');
            stand++;
            th1.innerHTML = `${team.strHomeTeam}`;
            th2.innerHTML = `${team.dateEvent}`;
            th3.innerHTML = `${team.strAwayTeam}`;
            append(indexResults, tr);
            append(tr, th1);
            append(tr, th2);
            append(tr, th3);
        })
    })
    .catch(function(error) {
        console.log(error);
    });
