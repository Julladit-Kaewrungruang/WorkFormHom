// $(window).ready(() => {
//     setActiveMenu();
// });


// const setActiveMenu = function(){
//     var pathArray = window.location.pathname.split('/');
//     console.log(pathArray)
//     let menu = !!pathArray[2]?pathArray[2]:'home';
//     $(`.menu-item[data-menu$='${window.location.pathname}']`).addClass('active')
//     console.log($(`.menu-item[data-menu$='${window.location.pathname}']`))
//     $(`.menu-item[data-menu*='${menu}']`).addClass('active')
//     if(!!pathArray[3]){
//         let submenu = !!pathArray[3]?pathArray[3]:'';
//         $(`.menu-item[data-menu*='${submenu}']`).addClass('active')
//     }
// }