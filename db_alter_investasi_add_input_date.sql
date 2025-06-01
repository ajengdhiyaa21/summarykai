-- Add input_date column to investasi table for filtering by month and year

ALTER TABLE investasi
ADD COLUMN input_date DATE DEFAULT NULL;
