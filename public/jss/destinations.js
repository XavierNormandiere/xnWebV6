function afficher_cana(cana)
{
    if(document.getElementById('cana').style.visibility==="hidden")
    {
        document.getElementById('cana').style.visibility="visible";
        document.getElementById('bouton_cana').innerHTML='Cliquez l\'icone pour embarquement';
    }
    else
    {
        document.getElementById(cana).style.visibility="hidden";
        document.getElementById('bouton_cana').innerHTML='Canada, province de Québec';
    }
    return true;
}

function afficher_nyc(nyc)
{
    if(document.getElementById('nyc').style.visibility==="hidden")
    {
        document.getElementById('nyc').style.visibility="visible";
        document.getElementById('bouton_nyc').innerHTML='Cliquez l\'icone pour embarquement';
    }
    else
    {
        document.getElementById(nyc).style.visibility="hidden";
        document.getElementById('bouton_nyc').innerHTML='USA, de New York à Boston';
    }
    return true;
}

function afficher_cali(cali)
{
    if(document.getElementById('cali').style.visibility==="hidden")
    {
        document.getElementById('cali').style.visibility="visible";
        document.getElementById('bouton_cali').innerHTML='Cliquez l\'icone pour embarquement';
    }
    else
    {
        document.getElementById(cali).style.visibility="hidden";
        document.getElementById('bouton_cali').innerHTML='USA, La Californie';
    }
    return true;
}

function afficher_equa(equa)
{
    if(document.getElementById('equa').style.visibility==="hidden")
    {
        document.getElementById('equa').style.visibility="visible";
        document.getElementById('bouton_equa').innerHTML='Cliquez l\'icone pour embarquement';
    }
    else
    {
        document.getElementById(equa).style.visibility="hidden";
        document.getElementById('bouton_equa').innerHTML='Equateur, de Quito au Cotopaxi';
    }
    return true;
}

function afficher_peru(peru)
{
    if(document.getElementById('peru').style.visibility==="hidden")
    {
        document.getElementById('peru').style.visibility="visible";
        document.getElementById('bouton_peru').innerHTML='Cliquez l\'icone pour embarquement';
    }
    else
    {
        document.getElementById(peru).style.visibility="hidden";
        document.getElementById('bouton_peru').innerHTML='Pérou, de Lima au Machupichu';
    }
    return true;
}

function afficher_stgo(stgo)
{
    if(document.getElementById('stgo').style.visibility==="hidden")
    {
        document.getElementById('stgo').style.visibility="visible";
        document.getElementById('bouton_stgo').innerHTML='Cliquez l\'icone pour embarquement';
    }
    else
    {
        document.getElementById(stgo).style.visibility="hidden";
        document.getElementById('bouton_stgo').innerHTML='Santiago du Chili';
    }
    return true;
}