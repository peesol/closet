import en from './en'
import th from './th'
export const categories = ({locale}) => {
  if (locale == 'th') {
    return th;
  } else {
    return en;
  }
}
