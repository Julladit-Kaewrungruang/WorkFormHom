
let config = {
  colors: {
    primary: '#696cff',
    secondary: '#8592a3',
    success: '#71dd37',
    info: '#03c3ec',
    warning: '#ffab00',
    danger: '#ff3e1d',
    dark: '#233446',
    black: '#000',
    white: '#fff',
    body: '#f4f5fb',
    headingColor: '#566a7f',
    axisColor: '#a1acb8',
    borderColor: '#eceef1'
  }
};

$(window).ready(() => {
  setActiveMenu();
  testCallAPI();
});
const setActiveMenu = function(){
  var pathArray = window.location.pathname.split('/');
  // console.log(pathArray)
  let menu = !!pathArray[1]?pathArray[1]:'home';
  $(`.menu-item[data-menu$='${window.location.pathname}']`).addClass('active')
  // console.log($(`.menu-item[data-menu$='${window.location.pathname}']`))
  $(`.menu-item[data-menu*='${menu}']`).addClass('active')
  if(!!pathArray[2]){
      let submenu = !!pathArray[2]?pathArray[2]:'';
      $(`.menu-item[data-menu*='${submenu}']`).addClass('active')
  }
}
let chartGraphExpireInYear;
function selectFilterYearInGraphContractExpire(year){
byId(`btn_FilterYearInGraphContractExpire`).innerHTML = year
dataDashboard_GraphExpireInYear(year)
}
