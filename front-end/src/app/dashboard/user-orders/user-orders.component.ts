

import { Component, OnInit } from '@angular/core';
import { Router } from '@angular/router';
import {OrderService} from '../../services/order.service';
import { Order } from '../../models/order';
import { FormsModule } from '@angular/forms';

import { CommonModule } from '@angular/common';


@Component({
  selector: 'app-user-orders',
  standalone: true,
  imports: [CommonModule,FormsModule],
  templateUrl: './user-orders.component.html',
  styleUrl: './user-orders.component.css'
})
export class UserOrdersComponent {
  constructor(public OrderService: OrderService ,public router:Router) { }

  orders : Order[]=this.OrderService.orders
  ngOnInit() {

    this.OrderService.getOrders().subscribe(data => {
      this.OrderService.orders.push(... data.data)});
  }

  cancel(id : number,i :number) {
    this.OrderService.cancel(id).subscribe(data=>console.log(data));
    this.orders[i].status = 'cancel'
  }

  editStatus(e : any, id :number) {
    if(e.target.value == "cancel"){
      this.OrderService.cancel(id).subscribe(data=>console.log(data));

    }else if(e.target.value =="done"){
      this.OrderService.done(id).subscribe(data=>console.log(data));

    }
  }
}
