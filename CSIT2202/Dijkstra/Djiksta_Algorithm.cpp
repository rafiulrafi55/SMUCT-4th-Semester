#include<bits/stdc++.h>
using namespace std;

class Graph {
private:
    int n; // no. of vertices
    vector<vector<pair<int, int> > > adjList; // Adjacency List
public:
    Graph(int V) {
        n = V; // assign no. of vertices
        adjList.resize(n); // Fixed number of vertices
    }

    void addEdge(int source, int destination, int weight, bool undir = true) {
        adjList[source].push_back({destination, weight});
        if (undir)
            adjList[destination].push_back({source, weight});
    }

    void printList() {
        for (int i=0; i<n; i++) {
            cout << "Source " << i << " -> ";
            for (const auto& p : adjList[i])
                cout << "(" << p.first << ", " << p.second << "), ";
            cout << endl;
        }
    }
};

int main() {

    Graph g(4);

    g.addEdge(0, 1, 4);
    g.addEdge(0, 3, 2);
    g.addEdge(3, 2, 3);
    g.addEdge(1, 3, 5);
    g.addEdge(1, 2, 1);

    g.printList();

    return 0;
}


