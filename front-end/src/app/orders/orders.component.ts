import { Component, OnInit } from '@angular/core';
import { Router } from '@angular/router';
import {OrderService} from '../services/order.service';
import { Order } from '../models/order';

import { CommonModule } from '@angular/common';



@Component({
  selector: 'app-orders',
  standalone: true,
  imports: [CommonModule],
  templateUrl: './orders.component.html',
  styleUrl: './orders.component.css'
})
export class OrdersComponent implements OnInit{

  constructor(public OrderService: OrderService ,public router:Router) { }

  orders : Order[]=this.OrderService.orders
  ngOnInit() {
    this.OrderService.getUserOrders().subscribe(data => {
      this.OrderService.orders.push(... data.data)});
  }

  cancel(id : number,i :number) {
    this.OrderService.cancel(id).subscribe(data=>console.log(data));
    this.orders[i].status = 'cancel'
  }

}
