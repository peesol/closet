export const category = ({locale}) => {
  if (locale == 'th') {
    return {
      men : 'ผู้ชาย',
      women : 'ผู้หญิง',
      bags_luggage : 'กระเป๋า',
      cosmetics : 'เครื่องสำอาง',
      skincare : 'ดูแลผิว',
      hair : 'ผลิตภัณฑ์เกี่ยวกับเส้นผม',
      personal_care : 'ของใช้ส่วนตัว',
      supplements : 'อาหารเสริม',
    }
  } else{
    return {
      men : 'Men',
      women : 'Women',
      bags_luggage : 'Luggage & Bags',
      cosmetics : 'Cosmetics',
      skincare : 'Skincare',
      hair : 'Hair Products',
      personal_care : 'Personal Care',
      supplements : 'Supplements',
    }
  }
}
