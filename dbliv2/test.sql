use dbliv2;
ALTER TABLE dbliv2.Booking ADD reservation_id INTEGER UNIQUE;
ALTER TABLE dbliv2.Booking ADD FOREIGN KEY (reservation_id) REFERENCES Reservation (reservation_id);