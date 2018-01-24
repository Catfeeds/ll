/**
 * Created by Administrator on 2017/6/18.
 */
var show=document.getElementsByClassName("show")[0];
var hide=document.getElementsByClassName("hide")[0];
var txt=document.getElementsByClassName("am-navbar-label")[0];


show.onclick=function () {
    show.style.display="none";
    hide.style.display="block";
    txt.style.color="#0743fc"

    show1.style.display="block";
    hide1.style.display="none";
    txt1.style.color="#adb5c4"

    show2.style.display="block";
    hide2.style.display="none";
    txt2.style.color="#adb5c4"
};
var show1=document.getElementsByClassName("show1")[0];
var hide1=document.getElementsByClassName("hide1")[0];
var txt1=document.getElementsByClassName("txt1")[0];


show1.style.display="none";
hide1.style.display="block";
txt1.style.color="#0743fc"
show1.onclick=function () {
    show.style.display="block";
    hide.style.display="none";
    txt.style.color="#adb5c4"

    show2.style.display="block";
    hide2.style.display="none";
    txt2.style.color="#adb5c4"

}
var show2=document.getElementsByClassName("show2")[0];
var hide2=document.getElementsByClassName("hide2")[0];
var txt2=document.getElementsByClassName("txt2")[0];

show2.onclick=function () {
    show2.style.display="none";
    hide2.style.display="block";
    txt2.style.color="#0743fc"

    show.style.display="block";
    hide.style.display="none";
    txt.style.color="#adb5c4"

    show1.style.display="block";
    hide1.style.display="none";
    txt1.style.color="#adb5c4"
}