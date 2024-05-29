import { Routes } from '@angular/router';
import { HomeComponent } from './homePage/home/home.component';
import { NotFoundComponent } from './not-found/not-found.component';
import { AuthGuard } from './guards/auth.guard';


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
      import('./products/product.route').then((m) => m.productroutes),
    canActivate: [AuthGuard],
  },
  {
    path: 'user',
    loadChildren: () =>
      import('./profile/user.route').then((m) => m.userRoutes),
  },
  {
    path: 'account',
    loadChildren: () =>
      import('./account/acount-route').then((m) => m.authRoutes),
  },
  {
    path: 'cart',
    loadChildren: () =>
      import('./cart/cart-route').then((m) => m.cartRoutes),
  },
  {
    path: 'order',
    loadChildren: () =>
      import('./orders/order-route').then((m) => m.orderRoutes),
  },
  {
    path: 'adminDashboard',
    loadChildren: () =>
      import('./dashboard/dashboard-route').then((m) => m.adminRoutes),
   
  },

  {
    path: '**',
    component: NotFoundComponent,
  }
];
