const calendar = document.getElementById('calendar');
const results = document.getElementById('results');
const urlCalendar = "https://www.thesportsdb.com/api/v1/json/1/eventsnextleague.php?id=4334";
fetch(urlCalendar)
    .then((resp)=>resp.json())
    .then(function(data) {
        let teams = data.events;
        let stand = 0;
        return teams.map(function(team){
            let tr = createNode('tr'),
                th1 = createNode('th'),
                th2 = createNode('th'),
                th3 = createNode('th'),
                date = team.strDate.substr(0,5),
                time = team.strTime.substr(0,5);
            stand++;

            th1.innerHTML = `${team.strHomeTeam}`;
            th2.innerHTML = `${date} <br> ${time}`;
            th3.innerHTML = `${team.strAwayTeam}`;
            append(results, tr);
            append(tr, th1);
            append(tr, th2);
            append(tr, th3);
        })
    })
const urlResults = "https://www.thesportsdb.com/api/v1/json/1/eventspastleague.php?id=4334";
fetch(urlResults)
    .then((resp)=>resp.json())
    .then(function(data) {
        let teams = data.events;
        return teams.map(function(team){
            let tr = createNode('tr'),
                th1 = createNode('th'),
                th2 = createNode('th'),
                th3 = createNode('th');

            th1.innerHTML = `${team.strHomeTeam}`;
            th2.innerHTML = `${team.intHomeScore} - ${team.intAwayScore}`;
            th3.innerHTML = `${team.strAwayTeam}`;
            if (team.intAwayScore != null){
                append(calendar, tr);
                append(tr, th1);
                append(tr, th2);
                append(tr, th3);}
        })
    })
    .catch(function(error) {
        console.log(error);
    });
