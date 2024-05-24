import { Routes } from '@angular/router';
import { HomeComponent } from './homePage/home/home.component';
import { NotFoundComponent } from './not-found/not-found.component';
import { ProductsViewComponent } from './products/products-view/products-view.component';

export const routes: Routes = [
  {
    path: 'home',
    component: HomeComponent,
  },
  {
    path: '',
    redirectTo: 'home',
    pathMatch: 'full',
  },{
    path: 'product',
    component:ProductsViewComponent ,
  },
  {
    path:"**",
    component:NotFoundComponent
  }
];
