CREATE TABLE travel_packages (
    id SERIAL PRIMARY KEY,
    package_name VARCHAR(100) NOT NULL,
    destination VARCHAR(100) NOT NULL,
    travel_date DATE NOT NULL,
    duration VARCHAR(50) NOT NULL,
    price DECIMAL(10,2) NOT NULL,
    seats_available INT NOT NULL,
    description TEXT NOT NULL,
    image_url VARCHAR(500) NOT NULL
);

INSERT INTO travel_packages (package_name, destination, travel_date, duration, price, seats_available, description, image_url)
VALUES
('Kashmir Snow Escape', 'Gulmarg, Kashmir', '2026-12-15', '5 Days / 4 Nights', 28999, 18, 'Experience the snow-covered mountains, winter landscapes and unforgettable beauty of Gulmarg.', 'https://images.unsplash.com/photo-1605649487212-4dcb18a2bc72?auto=format&fit=crop&w=800&q=80'),
('Dal Lake Dream', 'Srinagar, Kashmir', '2026-11-20', '4 Days / 3 Nights', 19999, 24, 'Enjoy the beauty of Srinagar with a peaceful Shikara experience on the iconic Dal Lake.', 'https://images.unsplash.com/photo-1595815771614-ade9d652a65d?auto=format&fit=crop&w=800&q=80'),
('Pahalgam Valley Retreat', 'Pahalgam, Kashmir', '2026-12-05', '5 Days / 4 Nights', 24999, 15, 'Explore the peaceful valleys, rivers and breathtaking mountain scenery of Pahalgam.', 'https://images.unsplash.com/photo-1626244498304-a1309dffefae?auto=format&fit=crop&w=800&q=80'),
('Sonamarg Winter Escape', 'Sonamarg, Kashmir', '2026-12-22', '4 Days / 3 Nights', 23999, 16, 'Discover the golden meadows, snowy mountains and spectacular Himalayan landscapes of Sonamarg.', 'https://images.unsplash.com/photo-1610214643330-84c1f1ec76d1?auto=format&fit=crop&w=800&q=80'),
('Doodhpathri Valley Retreat', 'Doodhpathri, Kashmir', '2027-01-08', '4 Days / 3 Nights', 21999, 20, 'Escape into the peaceful meadows, pine forests and beautiful streams of Doodhpathri.', 'https://images.unsplash.com/photo-1593693397690-362bb9a11542?auto=format&fit=crop&w=800&q=80'),
('Gurez Valley Expedition', 'Gurez Valley, Kashmir', '2027-01-18', '6 Days / 5 Nights', 32999, 12, 'Journey through the dramatic mountains, traditional villages and breathtaking landscapes of Gurez Valley.', 'https://images.unsplash.com/photo-1627915570081-0076a0d4c944?auto=format&fit=crop&w=800&q=80');
