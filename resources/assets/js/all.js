// window.addEventListener('load', function() {
//     (function() {
//
//       var myTabs = document.querySelectorAll(".tab-nav-btn");
//
//       function myTabClicks(tabClickEvent) {
//
//         for (var i = 0; i < myTabs.length; i++) {
//           myTabs[i].classList.remove("current");
//         }
//
//         var clickedTab = tabClickEvent.currentTarget;
//
//         clickedTab.classList.add("current");
//
//         tabClickEvent.preventDefault();
//
//         var myContentPanes = document.querySelectorAll(".tab-content");
//
//         for (i = 0; i < myContentPanes.length; i++) {
//           myContentPanes[i].classList.remove("current");
//         }
//         var anchorReference = tabClickEvent.target;
//         var activePaneId = anchorReference.getAttribute("data-tab");
//         var activePane = document.querySelector(activePaneId);
//
//         activePane.classList.add("current");
//
//       }
//
//       for (i = 0; i < myTabs.length; i++) {
//         myTabs[i].addEventListener("click", myTabClicks)
//       }
//
//     })();
//
// });
