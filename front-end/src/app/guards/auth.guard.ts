import { inject } from '@angular/core';
import { CanActivateFn, Router } from '@angular/router';
import { AuthService } from '../services/auth.service';

export const authGuard: CanActivateFn = (route, state) => {
  let accountService=inject(AuthService);
  if(accountService.isLoggedIn())
  return true;
else {
let router=inject(Router);
router.navigateByUrl('/login');
return false
}
};
