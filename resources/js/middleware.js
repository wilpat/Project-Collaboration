exports.requiresAuth = (to, from, next, state) => {

    if (to.matched.some(record => record.meta.requiresUserAuth) && state.user.is_auth === false) {
  
      state.user.error = 'You need to log in before you can perform this action.'
      next({
            path:'/login',
            query: { redirect: to.fullPath }
          })
    } else {
      next()
    }
    
  }
  
//   exports.requiresNoAuth = (to, from, next, state) => {
//     if (to.matched.some(record => record.meta.requiresNoUserAuth) && state.user.is_auth === true) {
//       next('/dashboard')
//     } else {
//       next()
//     }
//   }