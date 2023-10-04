document.addEventListener("DOMContentLoaded", ucitavanjeStranice);

function ucitavanjeStranice()
{    
    var forma=document.getElementById("form1");
    console.log(forma);
   
    forma.addEventListener("submit", provjeraObrazca); 
    
    for(var i=0; i<forma.length; i++)
    {
        if (forma[i].type !== "submit" && forma[i].type !== "reset")
        forma[i].value= ""; 
    }
}

function provjeraObrazca(event)
{
    var forma=document.getElementById("form1");
    var greske = "";
    var lozinka = ""; 
         
    for(var i=0; i<forma.length; i++)
    {
        if(forma[i].value === "")
        {
            if(forma[i].name === "ime" || forma[i].name === "prezime" || forma[i].name === "email" || forma[i].name === "korsnickoime" || forma[i].name === "lozinka1" || forma[i].name === "lozinka2")
            { 
                greske += "\n Niste ispunili element: "+forma[i].name; 
            }
        } 
        else if (forma[i].name === "ime" || forma[i].name === "prezime")
        {
            if(forma[i].value[0] !== forma[i].value[0].toUpperCase())
            { 
                greske += "\n Početno slovo elementa "+forma[i].name + " mora biti veliko! "; 
            }
        } 
        else if (forma[i].name === "email")
        {
            if (!(forma[i].value.indexOf("@") != -1 && forma[i].value.indexOf(".") != -1))
            { 
              greske += "\n Neispravan format email adrese. ";
            } 
        }
        else if (forma[i].name === "korsnickoime")
        {
            if(forma[i].value.length < 5 || forma[i].value.length > 45)
            { 
                greske += "\n Korisničko ime nije ispravne dužine. "; 
            }
        }
        else if (forma[i].name === "lozinka1")
        {
            lozinka = forma[i].value; 
            if(forma[i].value.includes("!"))
            { greske += "\n  Lozinka ne smije sadržavati znak !. "; }
            if(forma[i].value.includes("?"))
            { greske += "\n  Lozinka ne smije sadržavati znak ?. "; }
            if(forma[i].value.includes("<"))
            { greske += "\n  Lozinka ne smije sadržavati znak <. "; }
            if(forma[i].value.includes(">"))
            { greske += "\n  Lozinka ne smije sadržavati znak >. "; }
            if(forma[i].value.includes("%"))
            { greske += "\n  Lozinka ne smije sadržavati znak %. "; }
            if(forma[i].value.includes("#"))
            { greske += "\n  Lozinka ne smije sadržavati znak #. "; }
            if(forma[i].value.includes("&"))
            { greske += "\n  Lozinka ne smije sadržavati znak &. "; }    
        }
        else if (forma[i].name === "lozinka2")
        {
            if(forma[i].value != lozinka)
            { 
                greske += "\n Lozinke nisu identične. "; 
            }
        }
    }

    if(greske.length !== 0)
    {
        alert(greske);
        event.preventDefault();
        return false;
    }
    else 
    {
        ucitavanjeStranice(); 
    }
}