import { Routes } from '@angular/router';
import { HomeComponent } from './homePage/home/home.component';
import { NotFoundComponent } from './not-found/not-found.component';
import { OrdersComponent } from './orders/orders.component';
import { CartComponent } from './cart/cart.component';
import { UserProfileComponent } from './profile/user-profile/user-profile.component';
import { RegisterComponent } from './account/register/register.component';
import { LoginComponent } from './account/login/login.component';
import { authGuard } from './guards/auth.guard';

export const routes: Routes = [
  {
    path: 'home',
    component: HomeComponent,
  },
  {
    path: '',
    redirectTo: 'home',
    pathMatch: 'full',
  },
  {
    path: 'products',
    loadChildren: () =>
      import('./products/product.route').then((m) => m.productroutes),canActivate:[authGuard]
  },
  {
    path: 'order',
    component: OrdersComponent,
  },
  {
    path: 'cart',
    component: CartComponent,
  },

  {
    path: 'profile',
    component: UserProfileComponent,
  },
  {
    path: 'registration',
    component: RegisterComponent,
  },
  { path: 'login', component: LoginComponent },
  {
    path: '**',
    component: NotFoundComponent,
  },
];
