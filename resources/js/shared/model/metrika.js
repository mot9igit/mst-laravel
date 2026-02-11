import { YM_ID } from './constants'

export const sendMetrik = (action) => {
  if (typeof window !== 'undefined' && typeof window.ym !== 'undefined') {
    if (process.env.NODE_ENV === 'production') {
      window.ym(YM_ID, 'reachGoal', action)
    } else {
      console.log('sendMetrik', action)
    }
  }
}
