import express from "express";
import cors from "cors";
import sportsRouter from "./routes/sports.js";
import teamsRouter from "./routes/teams.js";


const app = express();
const PORT = 5000;

app.use(cors());
app.use(express.json());

app.use("/api/sports", sportsRouter);
app.use("/api/teams", teamsRouter);


app.listen(PORT, () => {
	console.log(`Server running on http://localhost:${PORT}`);
});
