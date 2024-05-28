import { Component } from '@angular/core';
import { UserInfoComponent } from '../user-info/user-info.component';
import { UserOrdersComponent } from '../user-orders/user-orders.component';
import { EditInfoComponent } from '../edit-info/edit-info.component';
import { OrdersComponent } from '../../orders/orders.component';

@Component({
  selector: 'app-user-profile',
  standalone: true,
  imports: [UserInfoComponent,UserOrdersComponent, OrdersComponent],
  templateUrl: './user-profile.component.html',
  styleUrl: './user-profile.component.css'
})
export class UserProfileComponent {

}
