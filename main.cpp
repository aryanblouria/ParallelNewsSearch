//include the necessary packages
#include <bits/stdc++.h>
#include <omp.h>
using namespace std;

//driver function
int main()
{
    //create two-dimensional string array word_db for storing unique words
    string word_db[10000][6];

    //fill all of the positions in word_db with 0s
    fill(word_db[0], word_db[0] + 10000 * 6, "0");

    //initialize the necessary variables
    int count = 0, temp = 0, result = 0, index = 1;
    string str, keyword;

    //create ASCII art strings to display neat output in the terminal
    string title = R"(
__________                     .__  .__         .__     ____  __.                                    .___   _________                           .__
\______   \_____ ____________  |  | |  |   ____ |  |   |    |/ _|____ ___.__.__  _  _____________  __| _/  /   _____/ ____ _____ _______   ____ |  |__
 |     ___/\__  \\_  __ \__  \ |  | |  | _/ __ \|  |   |      <_/ __ <   |  |\ \/ \/ /  _ \_  __ \/ __ |   \_____  \_/ __ \\__  \\_  __ \_/ ___\|  |  \
 |    |     / __ \|  | \// __ \|  |_|  |_\  ___/|  |__ |    |  \  ___/\___  | \     (  <_> )  | \/ /_/ |   /        \  ___/ / __ \|  | \/\  \___|   Y  \
 |____|    (____  /__|  (____  /____/____/\___  >____/ |____|__ \___  > ____|  \/\_/ \____/|__|  \____ |  /_______  /\___  >____  /__|    \___  >___|  /
                \/           \/               \/               \/   \/\/                              \/          \/     \/     \/            \/     \/
    )";

    string columns = R"(
__________               __            _____          __  .__       .__              ___________
\______   _____    ____ |  | __       /  _  \________/  |_|__| ____ |  |   ____      \_   ____________  ____  ________ __  ____   ____   ____ ___.__.
 |       _\__  \  /    \|  |/ /      /  /_\  \_  __ \   __|  _/ ___\|  | _/ __ \      |    __) \_  __ _/ __ \/ ____|  |  _/ __ \ /    \_/ ___<   |  |
 |    |   \/ __ \|   |  |    <      /    |    |  | \/|  | |  \  \___|  |_\  ___/      |     \   |  | \\  ___< <_|  |  |  \  ___/|   |  \  \___\___  |
 |____|_  (____  |___|  |__|_ \     \____|__  |__|   |__| |__|\___  |____/\___  >     \___  /   |__|   \___  \__   |____/ \___  |___|  /\___  / ____|
        \/     \/     \/     \/             \/                    \/          \/          \/               \/   |__|          \/     \/     \/\/

        )";

    string time_taken = R"(
__________.__                 ___________       __
\__    ___|__| _____   ____   \__    ________  |  | __ ____   ____
  |    |  |  |/     \_/ __ \    |    |  \__  \ |  |/ _/ __ \ /    \
  |    |  |  |  Y Y  \  ___/    |    |   / __ \|    <\  ___/|   |  \
  |____|  |__|__|_|  /\___  >   |____|  (____  |__|_ \\___  |___|  /
                   \/     \/                 \/     \/    \/     \/
    )";

    //create file object of insert.php using ofstream class
    ofstream file("insert.php");

    //write config file inclusion code to the PHP file
    file << "<?php include('config.php'); "<<endl;

    //display the title ASCII art
    cout<<title<<endl;

    //use omp_get_wtime() function to get the start time
    double start_time = omp_get_wtime();

    //create parallel region with number of threads set as 4
    #pragma omp parallel for private(temp) num_threads(1)
    for(int j = 1; j <= 5; j++)
    {
        //create file objects of article text files using ifstream class
        string file_name = "Article" + to_string(j) + ".txt";
        ifstream file_stream(file_name);

        //while loop that iterates for every word in the article text
        while (file_stream >> str)
        {
            //boolean variable to check if the word was found in word_db
            bool found1 = false;

            //boolean variable to determine when to break out of the loop
            bool break_flag1 = false;

            //create parallel region to scan whether the word is already in word_db
            #pragma omp parallel for
            for (int i = 0; i < count; ++i)
            {
                //check if word is already in word_db and break flag is not set
                if(word_db[i][0] == str && !break_flag1)
                {
                    //set found flag to indicate that the word was found in word_db
                    found1 = true;

                    //set temp variable equal to the count of that specific word and increment it
                    temp = atoi(word_db[i][j].c_str());
                    temp++;

                    //write the SQL query to update the count of the specific word in the database, to the PHP file
                    file << "$query = \"UPDATE `list` SET `" << j << "`=" << temp << " WHERE `string`='" << str << "';\";"<<endl;
                    file << "mysqli_query($con,$query);"<<endl;

                    //initialize an object convert of the stringstream class
                    stringstream convert;

                    //store temp in the stringstream object
                    convert << temp;

                    //store the string representation of the value in temp to word_db
                    word_db[i][j] = convert.str();

                    //set the break flag
                    break_flag1 = true;
                }
            }

            //section that executes if the word is not found in the word_db
            if(!found1)
            {
                //section that must be executed by a single thread at a time
                //#pragma omp critical
                {
                    //add the word to word_db
                    word_db[count][0] = str;

                    //set the initial count of the word as 1
                    word_db[count][j] = '1';
                    count++;

                    //write the SQL query to insert values into the database based on the article the word is from
                    if(j == 1)
                    {
                        file << "$var=\"" << str << "\";" << "\n";
                        file << "$query = \"INSERT INTO `list`(`string`,`" << j << "`,`2`,`3`,`4`,`5`)VALUES ('\".$var.\"',1,0,0,0,0);\";"<<endl;
                        file << "mysqli_query($con,$query);"<<endl;
                    }
                    else if(j == 2)
                    {
                        file << "$var=\"" << str << "\";" << "\n";
                        file << "$query = \"INSERT INTO `list`(`string`,`1`,`" << j << "`,`3`,`4`,`5`)VALUES ('\".$var.\"',0,1,0,0,0);\";"<<endl;
                        file << "mysqli_query($con,$query);"<<endl;
                    }
                    else if(j == 3)
                    {
                        file << "$var=\""<< str << "\";" << "\n";
                        file << "$query = \"INSERT INTO `list`(`string`,`1`,`2`,`"<<j<<"`,`4`,`5`)VALUES ('\".$var.\"',0,0,1,0,0);\";"<<endl;
                        file << "mysqli_query($con,$query);"<<endl;
                    }
                    else if(j == 4)
                    {
                        file << "$var=\"" << str << "\";" << "\n";
                        file << "$query = \"INSERT INTO `list`(`string`,`1`,`2`,`3`,`" << j << "`,`5`)VALUES ('\".$var.\"',0,0,0,1,0);\";"<<endl;
                        file << "mysqli_query($con,$query);"<<endl;
                    }
                    else
                    {
                        file << "$var=\"" << str << "\";" << "\n";
                        file << "$query = \"INSERT INTO `list`(`string`,`1`,`2`,`3`,`4`,`" << j << "`)VALUES ('\".$var.\"',0,0,0,0,1);\";"<<endl;
                        file << "mysqli_query($con,$query);"<<endl;
                    }
                }
            }
        }
    }
    //write the terminating PHP code
    file << "?>";

    //get time by subtracting the start time from the current time
    double time = omp_get_wtime() - start_time;

    //take the search keyword as input from the user
    cout<<"Enter search keyword: ";
    cin>>keyword;

    //boolean variable to check if search query is found
    bool found = false;

    //boolean variable to determine when to break out of the loop
    bool break_flag2 = false;

    //loop to iterate over each word in the word_db
    //#pragma omp parallel for
    for (int i = 0; i < count; ++i)
    {
        //check if search keyword is found and break flag is not set
        if(word_db[i][0] == keyword && !break_flag2)
        {
            //set result as the index of found word
            result = i;

            //set found flag to true
            found = true;

            //set the break flag
            break_flag2 = true;
        }
    }

    //execute if the search query is not found in the database
    if(!found)
        cout<<"No results found for the provided search query."<<endl;
    else
    {
        //create a vector of integer pairs vec
        vector<pair<int, int>> vec;

        //create an iterator object for the vector of pairs
        vector<pair<int, int>> ::iterator it;

        //store the search query and its respective counts in the vector
        for (int i = 1; i <= 5; i++)
            vec.push_back(make_pair(atoi(word_db[result][i].c_str()),i));

        //sort the vector according to the frequencies of the word
        sort(vec.rbegin(), vec.rend());

        //display the ASCII art for column titles
        cout<<columns<<endl;

        //display the file names along with their respective frequencies of the word
        for(it = vec.begin(); it != vec.end(); it++)
            cout<<setw(15)<<index++<<setw(45)<<"Article "<<it->second<<setw(55)<<it->first<<endl;

        //clear the values inside the vector
        vec.clear();
    }

    //display the ASCII art for time taken title
    cout<<time_taken<<endl;

    //display the time taken for executing the search
    cout<<"   "<<time<<" seconds"<<endl;

    return 0;
}