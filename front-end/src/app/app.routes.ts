import { Routes } from '@angular/router';
import { HomeComponent } from './homePage/home/home.component';
import { NotFoundComponent } from './not-found/not-found.component';
import { OrdersComponent } from './orders/orders.component';


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
    loadChildren: () => import('./products/product.route').then(m => m.productroutes)
  },
  {
    path: 'order',
    component:OrdersComponent ,
  },
  {
    path:"**",
    component:NotFoundComponent
  }
];
