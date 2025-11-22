function go(){
    if (h == "jorge"){
        document.getElementById("form_jorge").style.display="block";
        document.getElementById("form_marcio").style.display="none";
        document.getElementById("form_leandro").style.display="none";
        document.getElementById("form_lucia").style.display="none";
    }
    if (h == "marcio"){
        document.getElementById("form_jorge").style.display="none";
        document.getElementById("form_marcio").style.display="block";
        document.getElementById("form_leandro").style.display="none";
        document.getElementById("form_lucia").style.display="none";
    }
    if (h == "leandro"){
        document.getElementById("form_jorge").style.display="none";
        document.getElementById("form_marcio").style.display="none";
        document.getElementById("form_leandro").style.display="block";
        document.getElementById("form_lucia").style.display="none";
    }
    if (h == "lucia"){
        document.getElementById("form_jorge").style.display="none";
        document.getElementById("form_marcio").style.display="none";
        document.getElementById("form_leandro").style.display="none";
        document.getElementById("form_lucia").style.display="block";
    }
}