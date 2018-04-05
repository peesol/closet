
window.addEventListener("load",function(){var t=document.querySelectorAll(".tab-nav-btn");function e(e){for(var r=0;r<t.length;r++)t[r].classList.remove("current");e.currentTarget.classList.add("current"),e.preventDefault();var n=document.querySelectorAll(".tab-content");for(r=0;r<n.length;r++)n[r].classList.remove("current");var a=e.target.getAttribute("data-tab");document.querySelector(a).classList.add("current")}for(i=0;i<t.length;i++)t[i].addEventListener("click",e)});
window.addEventListener('load', function () {
  document.querySelector('.category-nav-btn').addEventListener('click', function () {
     this.classList.toggle('clicked');
     document.querySelector('.filter').classList.toggle('display');
  });
})
